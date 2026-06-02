<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Agent\WalletController;
use App\Http\Controllers\Admin\AdminAgentController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Agent\AgentNetworkController;
use App\Http\Controllers\PaymentController;

// --- RUTE AKAR / LANDING PAGE UTAMA ---
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
});

// --- RUTE PUBLIK (BISA DIAKSES SIAPA SAJA) ---
Route::get('/register', [RegisterController::class, 'showRegistrationForm']);

Route::post('/register', [RegisterController::class, 'storeRegister']);
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
            return view('admin.dashboard');
        });
        
        // Rute verifikasi pembayaran pendaftaran (dari Fase 1 bagian 4)
        Route::post('/payment/{id}/verify', [\App\Http\Controllers\PaymentController::class, 'verifyPayment']);

        // --- RUTE BARU: MANAJEMEN PENARIKAN DANA (WITHDRAWAL) ---
        Route::get('/withdrawals', [\App\Http\Controllers\Admin\AdminWithdrawalController::class, 'index']);
        Route::post('/withdrawals/{id}/process', [\App\Http\Controllers\Admin\AdminWithdrawalController::class, 'process']);

        // --- KENDALI VERIFIKASI AGEN PENDING (Bagian 4.1 & 4.3) ---
        // Tampilan antrean agen pending
        Route::get('/agents/pending', [AdminAgentController::class, 'pendingIndex']);
        
        // Eksekusi tombol "Setujui" -> Ubah status 'active' & bagi bonus unilevel 10 tingkat
        Route::post('/agents/{id}/approve', [AdminAgentController::class, 'approveAgent']);
        
        // Eksekusi tombol "Tolak" -> Ubah status 'rejected'
        Route::post('/agents/{id}/reject', [AdminAgentController::class, 'rejectAgent']);


        // --- KENDALI VERIFIKASI PENARIKAN DANA / WD (Bagian 4.2) ---
        // Tampilan antrean permintaan WD keuangan agen
        Route::get('/withdrawals', [AdminWithdrawalController::class, 'index']);
        
        // Eksekusi tombol "Konfirmasi Transfer" -> Status WD berubah jadi approved
        Route::post('/withdrawals/{id}/approve', [AdminWithdrawalController::class, 'approveWithdrawal']);
        
        // Eksekusi tombol "Tolak / Refund" -> Batalkan WD & kembalikan saldo ke dompet agen
        Route::post('/withdrawals/{id}/reject', [AdminWithdrawalController::class, 'rejectWithdrawal']);
    });


    // KELOMPOK API KHUSUS AGEN / JAMAAH AKTIF
    Route::middleware(['is_agent'])->prefix('agent')->group(function () {
        Route::get('/dashboard', function () {
            return view('agent.dashboard');
        });

        // Rute finansial dompet agen (dari Fase 3)
        Route::get('/wallet', [WalletController::class, 'index']);
        Route::post('/wallet/withdraw', [WalletController::class, 'withdraw']);

        // --- RUTE JARINGAN GENEALOGI & STATISTIK ---
        Route::get('/network', [\App\Http\Controllers\Agent\AgentNetworkController::class, 'getGenealogyTree']);
        Route::get('/network/summary', [\App\Http\Controllers\Agent\AgentNetworkController::class, 'getNetworkSummary']); // RUTE BARU

        Route::get('/network', [AgentNetworkController::class, 'networkTree']);

        // Rute Bagian 3.1: Overview Dashboard Utama
        Route::get('/agent/dashboard', [AgentNetworkController::class, 'index']);

        // Rute Bagian 3.3: Struktur Pohon Jaringan (Accordion Tree)
        Route::get('/agent/network', [AgentNetworkController::class, 'networkTree']);

        // Rute Bagian 3.2: Dompet Keuangan & Riwayat Mutasi Bonus
        Route::get('/agent/wallet', [WalletController::class, 'index']);
        Route::post('/agent/wallet/withdraw', [WalletController::class, 'withdraw']);
    });

});

// Rute khusus untuk menangani upload dari tengah modal pembeku
Route::middleware(['auth'])->post('/api/payment/upload', [\App\Http\Controllers\Agent\AgentNetworkController::class, 'uploadProofOfPayment']);