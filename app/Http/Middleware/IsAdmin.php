<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan merupakan Admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'message' => 'Akses ditolak. Halaman ini hanya untuk manajemen Admin Pusat.'
        ], 403);
    }
}