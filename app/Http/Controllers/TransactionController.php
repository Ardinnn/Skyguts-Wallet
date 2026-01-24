<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 1. Ambil input tanggal dari user (Default ke Bulan Ini jika kosong)
        $filterDate = $request->input('date', date('Y-m'));

        // Pecah string "2026-01" menjadi Tahun "2026" dan Bulan "01"
        [$year, $month] = explode('-', $filterDate);

        // 2. Ambil data transaksi (Difilter Tahun & Bulan)
        $transactions = Transaction::where('user_id', $userId)
                        ->whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->orderBy('date', 'desc')
                        ->get();

        // 3. Hitung Total Pemasukan (Difilter Tahun & Bulan)
        $totalPemasukan = Transaction::where('user_id', $userId)
                        ->whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->where('type', 'income')
                        ->sum('amount');

        // 4. Hitung Total Pengeluaran (Difilter Tahun & Bulan)
        $totalPengeluaran = Transaction::where('user_id', $userId)
                        ->whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->where('type', 'expense')
                        ->sum('amount');

        // 5. Hitung Saldo
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Kirim variabel ke View (termasuk $filterDate agar tanggal di input tidak reset)
        return view('transactions.index', compact('transactions', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'filterDate'));
    }
    
    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi (Tambahkan validasi gambar)
        $request->validate([
            'title' => 'required|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // 2. Cek apakah user mengupload gambar?
        $imagePath = null; // Default kosong
        
        if ($request->hasFile('image')) {
            // Simpan ke folder public/images
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // 3. Simpan ke Database
        Transaction::create([
            'user_id' => Auth::id(),
            'title' => $request->title,      // Pakai title kamu
            'amount' => $request->amount,
            'category' => $request->category, // Pakai category kamu
            'type' => $request->type,
            'date' => $request->date,
            'image' => $imagePath,           // Masukkan path gambar di sini
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    // Menampilkan halaman edit
    public function edit(Transaction $transaction)
    {
        // Cek kepemilikan data (agar tidak bisa edit punya orang lain)
        if ($transaction->user_id != Auth::id()) {
            abort(403);
        }
        return view('transactions.edit', compact('transaction'));
    }

    // Menyimpan perubahan data
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id != Auth::id()) {
            abort(403);
        }

        // Validasi
        $request->validate([
            'title' => 'required|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'category' => 'required', // Tambahan validasi kategori
        ]);

        // Update data
        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    // Menghapus data
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id != Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    
    }

