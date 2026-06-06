<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $walletBalance = $user->balance ?? 0;

        $totalEarned = Transaction::where('user_id', $user->id)
            ->where('type', 'credit')
            ->sum('amount');

        $mutations = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($t) => [
                'created_at'  => $t->created_at->format('d M Y, H:i'),
                'description' => $t->description,
                'type'        => $t->type,
                'amount'      => $t->amount,
            ]);

        return view('agent.wallet', compact('walletBalance', 'totalEarned', 'mutations'));
    }

    public function withdraw(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'amount' => [
                'required',
                'integer',
                'min:50000',
                'max:' . ($user->balance ?? 0),
            ],
        ], [
            'amount.required' => 'Nominal penarikan wajib diisi.',
            'amount.min'      => 'Minimal penarikan adalah Rp 50.000.',
            'amount.max'      => 'Nominal melebihi saldo Anda saat ini.',
        ]);

        $amount = (int) $request->amount;

        DB::transaction(function () use ($user, $amount) {
            $freshUser = User::where('id', $user->id)
                ->lockForUpdate()
                ->first();

            if ($freshUser->balance < $amount) {
                throw new \Exception('Saldo tidak mencukupi.');
            }

            $freshUser->decrement('balance', $amount);

            Withdrawal::create([
                'user_id'        => $freshUser->id,
                'amount'         => $amount,
                'status'         => 'pending',
                'bank_name'      => $freshUser->bank_name,
                'account_number' => $freshUser->account_number,
                'account_name'   => $freshUser->account_name,
            ]);

            Transaction::create([
                'user_id'     => $freshUser->id,
                'amount'      => $amount,
                'type'        => 'debit',
                'category'    => 'withdrawal',
                'description' => 'Pengajuan Penarikan Dana sedang diproses',
            ]);
        });

        return redirect()->back()->with(
            'success',
            'Pengajuan penarikan Rp ' . number_format($amount, 0, ',', '.') . ' berhasil dikirim!'
        );
    }
}