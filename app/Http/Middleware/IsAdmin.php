<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan user sudah login dan benar-benar seorang Admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        // 2. Jika bukan admin, lempar balik ke halaman login dengan pesan peringatan web HTML
        auth()->logout(); // Opsional: paksa logout jika ada agen nakal coba tembus rute admin
        return redirect('/login')->with('error', 'Akses ditolak! Halaman tersebut hanya dapat diakses oleh Manajemen Admin Pusat.');
    }
}