<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Agent\WalletController;
use App\Http\Controllers\Admin\AdminAgentController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Agent\AgentNetworkController;
use App\Http\Controllers\PaymentController;

// ============================================================
// RUTE PUBLIK / LANDING
// ============================================================
Route::get('/', function () {
    return view('welcome');
});

// ============================================================
// AUTENTIKASI (TAMU)
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'storeRegister'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================================
// RUTE TERPROTEKSI (WAJIB LOGIN)
// ============================================================
Route::middleware(['auth'])->group(function () {

    // Upload bukti bayar bagi user yang masih berstatus pending
    Route::post('/payment/upload', [PaymentController::class, 'uploadProof'])->name('payment.upload');

    // --------------------------------------------------------
    // ADMIN
    // --------------------------------------------------------
    Route::middleware(['is_admin'])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard utama — tujuan redirect pertama kali setelah login admin
        Route::get('/dashboard', [AdminAgentController::class, 'dashboard'])->name('dashboard');

        // Manajemen Agen
        Route::get('/agents/pending', [AdminAgentController::class, 'pendingIndex'])->name('agents.pending');
        Route::post('/agents/{id}/approve', [AdminAgentController::class, 'approveAgent'])->name('agents.approve');
        Route::post('/agents/{id}/reject', [AdminAgentController::class, 'rejectAgent'])->name('agents.reject');

        // Verifikasi Pembayaran Manual
        Route::post('/payment/{id}/verify', [PaymentController::class, 'verifyPayment'])->name('payment.verify');

        // Manajemen Penarikan Dana (Withdrawal)
        Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::post('/withdrawals/{id}/approve', [AdminWithdrawalController::class, 'approveWithdrawal'])->name('withdrawals.approve');
        Route::post('/withdrawals/{id}/reject', [AdminWithdrawalController::class, 'rejectWithdrawal'])->name('withdrawals.reject');

        // Pengaturan Skema Bonus Unilevel
        Route::get('/bonus-settings', [AdminAgentController::class, 'bonusIndex'])->name('bonus.index');
        Route::post('/bonus-settings/update', [AdminAgentController::class, 'updateBonus'])->name('bonus.update');
    });

    // --------------------------------------------------------
    // AGEN
    // --------------------------------------------------------
    Route::middleware(['is_agent'])->prefix('agent')->name('agent.')->group(function () {

        Route::get('/dashboard', fn() => view('agent.dashboard'))->name('dashboard');

        // Dompet Digital
        Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
        Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');

        // Pohon Jaringan Unilevel
        Route::get('/network', [AgentNetworkController::class, 'networkTree'])->name('network.tree');
        Route::get('/network/summary', [AgentNetworkController::class, 'getNetworkSummary'])->name('network.summary');
    });

});

// API upload bukti bayar dari modal
Route::middleware(['auth'])
    ->post('/api/payment/upload', [AgentNetworkController::class, 'uploadProofOfPayment'])
    ->name('api.payment.upload');