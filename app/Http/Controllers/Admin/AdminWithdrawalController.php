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
     * 1. Menampilkan Halaman Antrean Penarikan Dana (Blade View)
     * Route: GET /admin/withdrawals
     */
    public function index()
    {
        $pendingWithdrawals = Withdrawal::with('user:id,name,email')
            ->where('status', 'pending')
            ->latest()
            ->get()
            ->map(fn($wd) => [
                'id'             => $wd->id,
                'user_id'        => $wd->user_id,
                'agent_name'     => $wd->user->name ?? '-',
                'bank_name'      => $wd->bank_name,
                'account_number' => $wd->account_number,
                'account_name'   => $wd->account_name,
                'amount'         => $wd->amount,
                'created_at'     => $wd->created_at->format('d M Y, H:i'),
            ])
            ->toArray();

        return view('admin.withdrawals.index', compact('pendingWithdrawals'));
    }

    /**
     * 2. Menyetujui Penarikan Dana (Form POST dari Blade)
     * Route: POST /admin/withdrawals/{id}/approve
     */
    public function approveWithdrawal($id)
    {
        $withdrawal = Withdrawal::where('status', 'pending')->findOrFail($id);

        DB::transaction(function () use ($withdrawal) {
            $wallet = Wallet::where('user_id', $withdrawal->user_id)->lockForUpdate()->first();

            // Ubah status menjadi approved
            $withdrawal->update([
                'status' => 'approved',
                'notes'  => 'Penarikan disetujui oleh Admin.',
            ]);

            // Catat mutasi debit ke tabel transactions
            Transaction::create([
                'user_id'     => $withdrawal->user_id,
                'amount'      => $withdrawal->amount,
                'type'        => 'debit',
                'category'    => 'withdrawal',
                'description' => "Penarikan komisi dicairkan ke rekening {$withdrawal->bank_name} ({$withdrawal->account_number})",
            ]);
        });

        return redirect()->back()->with('success', 'Penarikan dana berhasil dikonfirmasi dan mutasi debit telah dicatat.');
    }

    /**
     * 3. Menolak Penarikan Dana (Form POST dari Blade)
     * Route: POST /admin/withdrawals/{id}/reject
     */
    public function rejectWithdrawal($id)
    {
        $withdrawal = Withdrawal::where('status', 'pending')->findOrFail($id);

        DB::transaction(function () use ($withdrawal) {
            // Kembalikan saldo ke dompet agen
            $wallet = Wallet::where('user_id', $withdrawal->user_id)->lockForUpdate()->first();
            $wallet->increment('balance', $withdrawal->amount);

            // Ubah status menjadi rejected
            $withdrawal->update([
                'status' => 'rejected',
                'notes'  => 'Penarikan ditolak oleh Admin, saldo dikembalikan.',
            ]);
        });

        return redirect()->back()->with('success', 'Penarikan dana ditolak, saldo agen telah dikembalikan secara utuh.');
    }

    /**
     * 4. API: Menampilkan Daftar Penarikan (JSON untuk kebutuhan API eksternal)
     * Route: GET /api/admin/withdrawals?status=pending
     */
    public function indexApi(Request $request): JsonResponse
    {
        $status = $request->query('status', 'pending');

        $withdrawals = Withdrawal::with('user:id,name,email')
            ->where('status', $status)
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $withdrawals,
        ], 200);
    }

    /**
     * 5. API: Memproses Approve/Reject via JSON (untuk kebutuhan API eksternal)
     * Route: POST /api/admin/withdrawals/{id}/process
     */
    public function process(Request $request, $id): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes'  => 'nullable|string',
        ]);

        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan penarikan ini sudah diproses sebelumnya.',
            ], 400);
        }

        DB::transaction(function () use ($withdrawal, $request) {
            $wallet = Wallet::where('user_id', $withdrawal->user_id)->lockForUpdate()->first();

            if ($request->action === 'approve') {
                $withdrawal->update([
                    'status' => 'approved',
                    'notes'  => $request->notes ?? 'Penarikan disetujui oleh Admin.',
                ]);

                Transaction::create([
                    'user_id'     => $withdrawal->user_id,
                    'amount'      => $withdrawal->amount,
                    'type'        => 'debit',
                    'category'    => 'withdrawal',
                    'description' => "Penarikan komisi dicairkan ke rekening {$withdrawal->bank_name} ({$withdrawal->account_number})",
                ]);
            } else {
                $wallet->increment('balance', $withdrawal->amount);

                $withdrawal->update([
                    'status' => 'rejected',
                    'notes'  => $request->notes ?? 'Penarikan ditolak oleh Admin.',
                ]);
            }
        });

        $message = $request->action === 'approve'
            ? 'Penarikan dana berhasil disetujui dan mutasi debit telah dicatat.'
            : 'Penarikan dana ditolak, saldo agen telah dikembalikan secara utuh.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $withdrawal,
        ], 200);
    }
}