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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // 2. Jalankan Proses Autentikasi
        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. AMBIL DATA USER YANG BERHASIL LOGIN
            $user = \Illuminate\Support\Facades\Auth::user();
            
            // 4. KEMUDI PENGALIHAN BERDASARKAN ROLE RIIL
            if ($user->isAdmin()) { // atau $user->role === 'admin'
                // Jika Admin, lempar ke Dashboard Antrean Admin Pusat
                return redirect()->intended('/admin/agents/pending')
                                ->with('success', 'Selamat Datang Kembali, Admin Pusat!');
            }

            if ($user->isAgent()) { // atau $user->role === 'agent'
                // Jika Agen, lempar ke Dashboard Kerja Agen
                return redirect()->intended('/agent/dashboard')
                                ->with('success', 'Login berhasil!');
            }
        }

        // Jika baris di atas gagal dieksekusi (Email/Password salah)
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