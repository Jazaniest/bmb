<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Tentukan arah redirect atau info berdasarkan status & role
            $role = $user->isAdmin() ? 'admin' : 'agent';

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil.',
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role,
                    'status' => $user->status
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password yang Anda masukkan salah.',
        ], 401);
    }

    /**
     * Logika setelah user sukses melewati proses pencocokan email & password
     */
    protected function authenticated(Request $request, $user)
    {
        // Jika yang login adalah Super Admin pusat, lempar ke dashboard admin
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        // Jika dia adalah Agen (baik berstatus 'active' maupun 'pending'), lempar ke rute yang sama
        // Karena penguncian akun pending sudah ditangani oleh komponen blade 'modal-pending' secara global
        return redirect()->intended('/agent/dashboard');
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.'
        ], 200);
    }
}