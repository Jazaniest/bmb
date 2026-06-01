<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class BonusService
{
    /**
     * Eksekusi pembagian semua bonus ketika agen baru diaktifkan.
     */
    public function distribute($newUserId)
    {
        // Jalankan di dalam DB Transaction demi keamanan data finansial
        DB::transaction(function () use ($newUserId) {
            
            // 1. Ambil data user baru beserta sponsornya
            $newUser = User::with('sponsor')->findOrFail($newUserId);
            $sponsor = $newUser->sponsor;

            if (!$sponsor) {
                return; // Jika mendaftar tanpa sponsor (akun root pusat), tidak ada bonus yang dibagikan
            }

            // 2. BAGIKAN BONUS REKRUT / SPONSOR LANGSUNG (Rp 1.000.000)
            $this->addBonus(
                $sponsor->id, 
                1000000, // Nominal Bonus Rekrut Skema Utama
                'bonus_rekrut', 
                "Bonus rekrut langsung atas pendaftaran Agen baru: {$newUser->name}"
            );

            // 3. BAGIKAN BONUS PERTUMBUHAN LEVEL (Maksimal 10 Tingkat ke Atas)
            // Mengambil array ID upline dari terdekat sampai teratas, misal: [ID_Sponsor, ID_Kakek, ID_Buyut, ...]
            $uplineIds = $newUser->getUplineIds(); 
            
            // Definisikan nominal bonus per level berdasarkan Skema Utama
            $levelSettings = [
                1  => 100000, // Level 1
                2  => 100000, // Level 2
                3  => 100000, // Level 3 (Revisi: diubah menjadi Uang Cash biasa)
                4  => 75000,  // Level 4
                5  => 50000,  // Level 5
                6  => 25000,  // Level 6
                7  => 25000,  // Level 7
                8  => 25000,  // Level 8
                9  => 25000,  // Level 9
                10 => 25000,  // Level 10
            ];

            // Lakukan looping untuk menembakkan bonus ke setiap tingkat upline yang tersedia
            foreach ($uplineIds as $index => $uplineId) {
                $currentLevel = $index + 1; // Indeks array 0 berarti Upline Tingkat 1

                // Batasi pembagian hanya sampai maksimal level 10
                if ($currentLevel > 10) {
                    break;
                }

                // Ambil nominal bonus untuk level saat ini
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

    /**
     * Fungsi pembantu untuk mutasi saldo dompet dan mencatatkan riwayat transaksi
     */
    private function addBonus($userId, $amount, $category, $description)
    {
        // 1. Update atau Buat Dompet (Wallet) si penerima bonus
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0, 'total_earned' => 0]
        );

        // Tambahkan saldo aktif dan akumulasi pendapatan
        $wallet->increment('balance', $amount);
        $wallet->increment('total_earned', $amount);

        // 2. Catat mutasi uang masuk ke tabel transaksi
        Transaction::create([
            'user_id'     => $userId,
            'amount'      => $amount,
            'type'        => 'credit', // Uang masuk
            'category'    => $category,
            'description' => $description,
        ]);
    }
}