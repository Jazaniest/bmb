<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class AdminWithdrawalController extends Controller
{
    /**
     * 1. Menampilkan Semua Daftar Pengajuan Penarikan Dana (Untuk Antrean Admin)
     */
    public function index(Request $request): JsonResponse
    {
        // Menyediakan filter status (pending, approved, rejected) jika diperlukan
        $status = $request->query('status', 'pending');

        // Mengambil data penarikan beserta profil agennya
        $withdrawals = Withdrawal::with('user:id,name,email')
            ->where('status', $status)
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $withdrawals
        ], 200);
    }

    /**
     * 2. Memproses Persetujuan atau Penolakan Penarikan Dana
     */
    public function process(Request $request, $id): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string' // Alasan jika ditolak, atau nomor referensi bank jika disetujui
        ]);

        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan penarikan ini sudah diproses sebelumnya.'
            ], 400);
        }

        // Jalankan operasi dengan DB Transaction & Row Locking untuk keamanan finansial
        DB::transaction(function () use ($withdrawal, $request) {
            
            // Kunci baris data dompet agen yang bersangkutan selama proses ini berjalan
            $wallet = Wallet::where('user_id', $withdrawal->user_id)->lockForUpdate()->first();

            if ($request->action === 'approve') {
                // --- JIKA ADMIN MENYETUJUI ---
                // 1. Ubah status data penarikan menjadi approved
                $withdrawal->update([
                    'status' => 'approved',
                    'notes' => $request->notes ?? 'Penarikan disetujui oleh Admin.'
                ]);

                // 2. Catat secara resmi mutasi keluar (debit) ke tabel transactions
                Transaction::create([
                    'user_id' => $withdrawal->user_id,
                    'amount' => $withdrawal->amount,
                    'type' => 'debit', // Uang keluar
                    'category' => 'withdrawal',
                    'description' => "Penarikan komisi dicairkan ke rekening {$withdrawal->bank_name} ({$withdrawal->account_number})"
                ]);

            } else {
                // --- JIKA ADMIN MENOLAK ---
                // 1. Kembalikan uang komisi ke saldo dompet agen secara utuh
                $wallet->increment('balance', $withdrawal->amount);

                // 2. Ubah status penarikan menjadi rejected beserta alasannya
                $withdrawal->update([
                    'status' => 'rejected',
                    'notes' => $request->notes ?? 'Penarikan ditolak oleh Admin.'
                ]);
            }
        });

        $message = $request->action === 'approve' 
            ? 'Penarikan dana berhasil disetujui dan mutasi debit telah dicatat.' 
            : 'Penarikan dana ditolak, saldo agen telah dikembalikan secara utuh.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $withdrawal
        ], 200);
    }
}