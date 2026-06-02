<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAgent
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan user sudah login dan tipenya adalah Agen
        if (auth()->check() && auth()->user()->isAgent()) {
            
            // 2. PROTEKSI KHUSUS STATUS PENDING
            // Jika agen mencoba mengakses rute sensitif (seperti dompet/jaringan) tapi statusnya belum 'active'
            if (auth()->user()->status !== 'active') {
                
                // Jika mereka hanya mengakses halaman dashboard utama, izinkan lewat agar bisa upload bukti transfer
                if ($request->is('agent/dashboard')) {
                    return $next($request);
                }

                // Jika mereka mencoba membuka rute /agent/wallet atau /agent/network secara paksa, kunci dan kunci balik ke dashboard
                return redirect('/agent/dashboard')->with('error', 'Akun Anda masih berstatus pending. Silakan selesaikan pembayaran pendaftaran terlebih dahulu untuk membuka fitur ini.');
            }
            
            // 3. Jika status sudah 'active', bebas akses seluruh rute agen
            return $next($request);
        }

        // 4. Jika publik/admin kesasar ke rute agen
        return redirect('/login')->with('error', 'Akses ditolak. Anda tidak memiliki otoritas Agen.');
    }
}