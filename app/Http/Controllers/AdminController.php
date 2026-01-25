<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Cek apakah yang akses adalah Admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang boleh masuk sini.');
        }

        // Ambil semua user selain admin, beserta transaksinya
        $users = User::where('role', '!=', 'admin')
                     ->with('transactions') // Ambil data transaksi sekalian
                     ->get();

        // Kita modifikasi koleksi usernya untuk menambahkan info saldo
        foreach ($users as $user) {
            $pemasukan = $user->transactions->where('type', 'income')->sum('amount');
            $pengeluaran = $user->transactions->where('type', 'expense')->sum('amount');
            $user->saldo_saat_ini = $pemasukan - $pengeluaran;
        }

        return view('admin.users', compact('users'));
    }
}