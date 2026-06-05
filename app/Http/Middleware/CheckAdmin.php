<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Menangani pengecekan hak akses masuk rute khusus Super Admin Pusat
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan pengguna sudah login terlebih dahulu
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // 2. Periksa apakah pengguna memiliki role 'admin'
        // Jika bukan admin (misal: 'agent'), tolak akses dan lempar balik ke dashboard mereka sendiri
        if (auth()->user()->role !== 'admin') {
            return redirect('/agent/dashboard')->with('error', 'Akses ditolak! Halaman tersebut hanya dapat diakses oleh Manajemen Pusat PT. BMB.');
        }

        // 3. Jika lolos verifikasi, izinkan request melanjutkan perjalanan ke Controller
        return $next($request);
    }
}