<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Tambahkan ini buat hapus gambar lama

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id(); // Ambil ID User yang sedang login

        // 1. Ambil input tanggal (Default ke Bulan Ini)
        $filterDate = $request->input('date', date('Y-m'));
        [$year, $month] = explode('-', $filterDate);

        // --- BAGIAN 1: DATA UNTUK TABEL (DAFTAR TRANSAKSI) ---
        $query = Transaction::query();

        // Kalau BUKAN Admin, paksa cuma lihat punya sendiri
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', $userId);
        }

        // Ambil data untuk tabel
        $transactions = $query->with('user')
                              ->whereYear('date', $year)
                              ->whereMonth('date', $month)
                              ->orderBy('date', 'desc')
                              ->get();


        // --- BAGIAN 2: DATA UNTUK KARTU SALDO (KHUSUS PRIBADI) ---
        // Kita query ulang KHUSUS untuk menghitung saldo PRIBADI saja.
        // Jadi walaupun Admin melihat data orang lain di tabel,
        // Kartu saldonya tetap menunjukkan uang dia sendiri.
        
        $personalTransactions = Transaction::where('user_id', $userId)
                                           ->whereYear('date', $year)
                                           ->whereMonth('date', $month)
                                           ->get();

        $totalPemasukan = $personalTransactions->where('type', 'income')->sum('amount');
        $totalPengeluaran = $personalTransactions->where('type', 'expense')->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;


        // Kirim ke View
        return view('transactions.index', compact('transactions', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'filterDate'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'category' => $request->category,
            'type' => $request->type,
            'date' => $request->date,
            'image' => $imagePath,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function edit(Transaction $transaction)
    {
        // PERBAIKAN: Admin BOLEH akses, atau Pemilik Asli BOLEH akses
        if ($transaction->user_id != Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak berhak mengedit data ini.');
        }
        
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // PERBAIKAN: Admin BOLEH akses
        if ($transaction->user_id != Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // PERBAIKAN: Logic Update Gambar
        $data = $request->all();

        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama jika ada
            if ($transaction->image) {
                Storage::disk('public')->delete($transaction->image);
            }
            // 2. Upload gambar baru
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $transaction->update($data);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        // PERBAIKAN: Admin BOLEH akses
        if ($transaction->user_id != Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Hapus gambar dari penyimpanan jika ada
        if ($transaction->image) {
            Storage::disk('public')->delete($transaction->image);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}