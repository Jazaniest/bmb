<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class AdminWithdrawalController extends Controller
{
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

    public function approveWithdrawal($id)
    {
        $withdrawal = Withdrawal::where('status', 'pending')->findOrFail($id);

        DB::transaction(function () use ($withdrawal) {
            // ✅ Tidak perlu sentuh saldo — saldo sudah dipotong saat agen request WD
            $withdrawal->update([
                'status' => 'approved',
                'notes'  => 'Penarikan disetujui oleh Admin.',
            ]);

            Transaction::create([
                'user_id'     => $withdrawal->user_id,
                'amount'      => $withdrawal->amount,
                'type'        => 'debit',
                'category'    => 'withdrawal',
                'description' => "Penarikan komisi dicairkan ke rekening {$withdrawal->bank_name} ({$withdrawal->account_number})",
            ]);
        });

        return redirect()->back()->with('success', 'Penarikan dana berhasil dikonfirmasi.');
    }

    public function rejectWithdrawal($id)
    {
        $withdrawal = Withdrawal::where('status', 'pending')->findOrFail($id);

        DB::transaction(function () use ($withdrawal) {
            // ✅ Kembalikan saldo ke users.balance (bukan wallets)
            User::where('id', $withdrawal->user_id)
                ->lockForUpdate()
                ->first()
                ->increment('balance', $withdrawal->amount);

            $withdrawal->update([
                'status' => 'rejected',
                'notes'  => 'Penarikan ditolak oleh Admin, saldo dikembalikan.',
            ]);

            // ✅ Catat kredit balik agar histori mutasi agen akurat
            Transaction::create([
                'user_id'     => $withdrawal->user_id,
                'amount'      => $withdrawal->amount,
                'type'        => 'credit',
                'category'    => 'withdrawal',
                'description' => 'Penarikan dana ditolak — saldo dikembalikan ke dompet',
            ]);
        });

        return redirect()->back()->with('success', 'Penarikan ditolak, saldo agen telah dikembalikan.');
    }

    public function indexApi(Request $request): JsonResponse
    {
        $status = $request->query('status', 'pending');

        $withdrawals = Withdrawal::with('user:id,name,email')
            ->where('status', $status)
            ->latest()
            ->paginate(10);

        return response()->json(['success' => true, 'data' => $withdrawals], 200);
    }

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
                'message' => 'Pengajuan ini sudah diproses sebelumnya.',
            ], 400);
        }

        DB::transaction(function () use ($withdrawal, $request) {
            if ($request->action === 'approve') {
                // ✅ Saldo sudah dipotong saat request — cukup update status
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
                // ✅ Kembalikan saldo ke users.balance
                User::where('id', $withdrawal->user_id)
                    ->lockForUpdate()
                    ->first()
                    ->increment('balance', $withdrawal->amount);

                $withdrawal->update([
                    'status' => 'rejected',
                    'notes'  => $request->notes ?? 'Penarikan ditolak oleh Admin.',
                ]);

                Transaction::create([
                    'user_id'     => $withdrawal->user_id,
                    'amount'      => $withdrawal->amount,
                    'type'        => 'credit',
                    'category'    => 'withdrawal',
                    'description' => 'Penarikan dana ditolak — saldo dikembalikan ke dompet',
                ]);
            }
        });

        $message = $request->action === 'approve'
            ? 'Penarikan berhasil disetujui.'
            : 'Penarikan ditolak, saldo agen telah dikembalikan.';

        return response()->json(['success' => true, 'message' => $message, 'data' => $withdrawal], 200);
    }
}