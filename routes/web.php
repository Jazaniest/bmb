<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// --- RUTE PUBLIK (BISA DIAKSES SIAPA SAJA) ---
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

// --- RUTE TERPROTEKSI (WAJIB LOGIN) ---
Route::middleware(['auth'])->group(function () {

    // 1. Rute Khusus User yang masih PENDING (Baru daftar, mau upload bukti bayar)
    // Rute ini ditaruh di luar middleware 'is_agent' karena 'is_agent' mengunci hanya untuk yang sudah 'active'
    Route::post('/payment/upload', [PaymentController::class, 'uploadProof']);


    // 2. KELOMPOK API KHUSUS ADMIN PUSAT (Untuk Verifikasi Bukti)
    Route::middleware(['is_admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Selamat datang di Panel Admin Kaukaba Travel.']);
        });
        
        // Rute verifikasi pembayaran berdasarkan ID Invoice
        Route::post('/payment/{id}/verify', [PaymentController::class, 'verifyPayment']);
    });


    // 3. KELOMPOK API KHUSUS AGEN / JAMAAH AKTIF
    Route::middleware(['is_agent'])->prefix('agent')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Selamat datang di Ruang Kerja Agen Kaukaba. Akun Anda resmi aktif!']);
        });
    });

});