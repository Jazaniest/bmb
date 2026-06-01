<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAgent
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login, merupakan Agent, dan akunnya sudah AKTIF (Lunas Rp 3.500.000)
        if (auth()->check() && auth()->user()->isAgent()) {
            if (auth()->user()->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda masih berstatus pending. Silakan selesaikan pembayaran pendaftaran terlebih dahulu untuk mengakses dashboard.'
                ], 403);
            }
            
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'message' => 'Akses ditolak. Anda tidak memiliki otoritas Agen.'
        ], 403);
    }
}