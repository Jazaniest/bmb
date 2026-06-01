<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminAgentController extends Controller
{
    /**
     * Memproses Persetujuan Aktivasi Agen Baru & Distribusi Komisi Berjenjang
     */
    public function approveAgent($id)
    {
        // 1. Cari data calon agen yang berstatus pending
        $agent = User::where('role', 'agent')->where('status', 'pending')->findOrFail($id);

        // 2. Bungkus proses dengan DB Transaction untuk menjamin konsistensi data (ACID)
        // Jika ada satu query yang gagal di tengah jalan, seluruh pemotongan/penambahan saldo akan dibatalkan otomatis
        DB::beginTransaction();

        try {
            // 3. Ubah status agen menjadi aktif
            $agent->update([
                'status' => 'active',
                'email_verified_at' => now() // Menandakan verifikasi selesai
            ]);

            // 4. Jalankan Mesin Distribusi Komisi ke Atasan (Maksimal 10 Tingkat)
            $this->distributeUnilevelBonus($agent);

            DB::commit();
            return redirect()->back()->with('success', 'Akun Agen ' . $agent->name . ' berhasil diaktifkan dan bonus komisi jaringan telah didistribusikan secara real-time!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Logika Inti Pembagian Bonus Unilevel Matahari 10 Tingkat
     */
    private function distributeUnilevelBonus(User $agent)
    {
        $currentSponsorId = $agent->sponsor_id;
        $currentLevel = 1; // Dimulai dari Level 1 tepat di atas agen baru

        // Lakukan perulangan (looping) merangkak naik ke atas silsilah keluarga hingga Level 10
        while ($currentSponsorId !== null && $currentLevel <= 10) {
            
            // Ambil data atasan saat ini
            $sponsor = User::find($currentSponsorId);
            
            if (!$sponsor) {
                break; // Jika data atasan tidak ditemukan, hentikan perulangan
            }

            // Atasan hanya bisa menerima bonus jika status akunnya sudah 'active'
            if ($sponsor->status === 'active') {
                
                // Tentukan jumlah komisi berdasarkan level kedalaman
                if ($currentLevel === 1) {
                    // Level 1 mendapatkan Bonus Rekrutmen Langsung
                    $bonusAmount = 2000000; 
                    $description = "Bonus Rekrutmen Langsung dari Agen Baru: " . $agent->name;
                } else {
                    // Level 2 sampai 10 mendapatkan Bonus Kedalaman Generasi
                    $bonusAmount = 100000; 
                    $description = "Bonus Kedalaman Generasi (Level " . $currentLevel . ") dari Agen: " . $agent->name;
                }

                // Tambahkan saldo dompet digital atasan
                $sponsor->increment('balance', $bonusAmount);

                // Catat transaksi masuk ke tabel mutasi dompet milik atasan
                $sponsor->mutations()->create([
                    'description' => $description,
                    'type' => 'credit',
                    'amount' => $bonusAmount
                ]);
            }

            // Alihkan pencarian ke atasnya lagi (Naik 1 silsilah tingkat lebih tinggi)
            $currentSponsorId = $sponsor->sponsor_id;
            $currentLevel++;
        }
    }

    /**
     * Memproses Penolakan Aktivasi Calon Agen
     */
    public function rejectAgent($id)
    {
        $agent = User::where('role', 'agent')->where('status', 'pending')->findOrFail($id);
        
        // Cukup ubah status atau hapus data jika bukti transfer palsu/tidak valid
        $agent->update(['status' => 'rejected']); // atau $agent->delete();

        return redirect()->back()->with('success', 'Pendaftaran agen ' . $agent->name . ' telah ditolak.');
    }
}