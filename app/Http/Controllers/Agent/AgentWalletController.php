<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class AgentWalletController extends Controller
{
    /**
     * 1. Mengambil Informasi Saldo & Ringkasan Dompet Agen
     */
    public function getWalletInfo(): JsonResponse
    {
        $user = auth()->user();

        // Ambil atau buat dompet jika belum ada
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0, 'total_earned' => 0]
        );

        // Ambil 5 riwayat transaksi terakhir untuk ringkasan dashboard
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'balance' => $wallet->balance,
                'total_earned' => $wallet->total_earned,
                'recent_transactions' => $recentTransactions
            ]
        ], 200);
    }

    /**
     * 2. Mengajukan Penarikan Dana (Withdrawal Request)
     */
    public function requestWithdraw(Request $request): JsonResponse
    {
        // Tentukan batas minimum penarikan dana (misal: Rp 50.000)
        $minimumWithdraw = 50000;

        $request->validate([
            'amount' => 'required|numeric|min:' . $minimumWithdraw,
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
        ]);

        $user = auth()->user();
        $withdrawAmount = $request->amount;

        // Gunakan DB Transaction dan Lock demi keamanan saldo finansial
        $withdrawal = DB::transaction(function () use ($user, $withdrawAmount, $request) {
            
            // Mengunci baris dompet user saat ini agar tidak bisa dimanipulasi request lain
            $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->first();

            if (!$wallet) {
                throw new \Exception('Dompet tidak ditemukan.');
            }

            // Validasi: Apakah saldo aktif saat ini mencukupi?
            if ($wallet->balance < $withdrawAmount) {
                throw new \Exception('Saldo Anda tidak mencukupi untuk melakukan penarikan ini.');
            }

            // POTONG SALDO SEBELUM DI-APPROVE (STATUS PENDING)
            // Ini untuk mengunci uang agen agar tidak bisa ditarik ulang secara ganda
            $wallet->decrement('balance', $withdrawAmount);

            // Buat draf transaksi keluar (debit) berstatus pending
            return Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $withdrawAmount,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'status' => 'pending', // Menunggu persetujuan admin pusat
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan penarikan komisi berhasil dikirim. Saldo Anda dipotong sementara dan sedang menunggu transfer manual dari Admin Pusat.',
            'data' => $withdrawal
        ], 201);
    }
}