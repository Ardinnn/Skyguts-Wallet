<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    // 1. Fungsi untuk melempar user ke halaman Login Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Fungsi untuk menerima user balik dari Google
    public function callback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari: Apakah user ini sudah pernah login pakai Google?
            $user = User::where('google_id', $googleUser->id)->first();

            // Kalau belum ada, Cek: Apakah emailnya sudah terdaftar manual?
            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();

                if ($user) {
                    // Kalau email ada, kita update google_id nya (Link Account)
                    $user->update(['google_id' => $googleUser->id]);
                } else {
                    // Kalau benar-benar user baru, kita buatkan akun
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'role' => 'member', // Default jadi member
                        'password' => Hash::make(Str::random(16)), // Password acak (karena login via google)
                    ]);
                }
            }

            // Login-kan user tersebut
            Auth::login($user);

            // Redirect ke halaman Transaksi
            return redirect()->route('transactions.index');

        } catch (\Exception $e) {
            // Kalau gagal, balik ke login dengan pesan error
            return redirect()->route('login')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }
}