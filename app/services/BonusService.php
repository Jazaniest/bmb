<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class BonusService
{
    public function distribute($newUserId)
    {
        DB::transaction(function () use ($newUserId) {
            $newUser = User::with('sponsor')->findOrFail($newUserId);
            $sponsor = $newUser->sponsor;

            if (!$sponsor) {
                return;
            }

            // Bonus rekrut langsung ke sponsor
            $this->addBonus(
                $sponsor->id,
                1000000,
                'bonus_rekrut',
                "Bonus rekrut langsung atas pendaftaran Agen baru: {$newUser->name}"
            );

            // Bonus level ke upline
            $uplineIds = $newUser->getUplineIds();

            $levelSettings = [
                1  => 100000,
                2  => 100000,
                3  => 100000,
                4  => 75000,
                5  => 50000,
                6  => 25000,
                7  => 25000,
                8  => 25000,
                9  => 25000,
                10 => 25000,
            ];

            foreach ($uplineIds as $index => $uplineId) {
                $currentLevel = $index + 1;

                if ($currentLevel > 10) break;

                $bonusAmount = $levelSettings[$currentLevel] ?? 0;

                if ($bonusAmount > 0) {
                    $this->addBonus(
                        $uplineId,
                        $bonusAmount,
                        'bonus_level',
                        "Bonus pertumbuhan jaringan Level {$currentLevel} dari pendaftaran: {$newUser->name}"
                    );
                }
            }
        });
    }

    private function addBonus($userId, $amount, $category, $description)
    {
        // ✅ Tambah saldo langsung ke users.balance (Opsi A)
        User::where('id', $userId)
            ->lockForUpdate()
            ->first()
            ->increment('balance', $amount);

        // ✅ Catat riwayat transaksi
        Transaction::create([
            'user_id'     => $userId,
            'amount'      => $amount,
            'type'        => 'credit',
            'category'    => $category,
            'description' => $description,
        ]);
    }
}