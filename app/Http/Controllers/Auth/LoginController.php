<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // 2. Jalankan Proses Autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Ambil data user yang berhasil login
            $user = Auth::user();

            // 4. Kemudi pengalihan berdasarkan role
            if ($user->isAdmin()) {
                // Jika Admin, arahkan ke dashboard pusat
                return redirect('/admin/dashboard')
                    ->with('success', 'Selamat Datang Kembali, Admin Pusat!');
            }

            if ($user->isAgent()) {
                // Jika Agen, arahkan ke dashboard agen
                return redirect('/agent/dashboard')
                    ->with('success', 'Login berhasil!');
            }
        }

        // Jika autentikasi gagal (email/password salah)
        return back()->withErrors([
            'email' => 'Kredensial yang Anda masukkan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}