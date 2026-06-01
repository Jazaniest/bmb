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


    // KELOMPOK API KHUSUS ADMIN PUSAT
    Route::middleware(['is_admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Selamat datang di Panel Admin Kaukaba Travel.']);
        });
        
        // Rute verifikasi pembayaran pendaftaran (dari Fase 1 bagian 4)
        Route::post('/payment/{id}/verify', [\App\Http\Controllers\PaymentController::class, 'verifyPayment']);

        // --- RUTE BARU: MANAJEMEN PENARIKAN DANA (WITHDRAWAL) ---
        Route::get('/withdrawals', [\App\Http\Controllers\Admin\AdminWithdrawalController::class, 'index']);
        Route::post('/withdrawals/{id}/process', [\App\Http\Controllers\Admin\AdminWithdrawalController::class, 'process']);
    });


    // KELOMPOK API KHUSUS AGEN / JAMAAH AKTIF
    Route::middleware(['is_agent'])->prefix('agent')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Selamat datang di Ruang Kerja Agen Kaukaba. Akun Anda resmi aktif!']);
        });

        // --- RUTE FINANSIAL DOMPET AGEN ---
        Route::get('/wallet', [\App\Http\Controllers\Agent\AgentWalletController::class, 'getWalletInfo']);
        Route::post('/wallet/withdraw', [\App\Http\Controllers\Agent\AgentWalletController::class, 'requestWithdraw']);
    });

});