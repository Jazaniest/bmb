<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Tampilkan Halaman Visual Dompet Keuangan Agen (Web View)
     */
    public function index()
    {
        $user = auth()->user();

        // 1. Ambil data finansial langsung dari properti user
        $walletBalance = $user->balance ?? 0;
        
        // 2. Hitung total komisi akumulatif yang pernah didapatkan (akumulasi mutasi tipe masuk/credit)
        // Jika Anda belum membuat relasi mutations, kita set default 0 dulu agar tidak error
        $totalEarned = method_exists($user, 'mutations') 
            ? $user->mutations()->where('type', 'credit')->sum('amount') 
            : 0;

        // 3. Ambil riwayat mutasi dompet terbaru
        $mutations = method_exists($user, 'mutations') 
            ? $user->mutations()->latest()->take(10)->get() 
            : [];

        // 4. OPER DATA KE TEMPLATE BLADE (Bukan mengembalikan JSON)
        return view('agent.wallet', compact('walletBalance', 'totalEarned', 'mutations'));
    }

    /**
     * Bagian 3.2: Proses Eksekusi Form Request Withdrawal (WD)
     */
    public function withdraw(Request $request)
    {
        $user = auth()->user();

        // 1. Validasi nominal penarikan dana dari form
        $request->validate([
            'amount' => 'required|integer|min:50000|max:' . $user->balance,
        ]);

        $amount = $request->amount;

        // 2. Eksekusi transaksi database menggunakan DB Transaction agar aman (anti-race condition)
        DB::transaction(function () use ($user, $amount) {
            // Potong saldo aktif user langsung di database
            $user->decrement('balance', $amount);

            // Catat log pengajuan ke tabel withdrawals untuk diverifikasi admin pusat nanti
            Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'status' => 'pending', // Menunggu approval dari Admin HQ
                'bank_name' => $user->bank_name,
                'account_number' => $user->account_number,
                'account_name' => $user->account_name
            ]);

            // Catat ke tabel mutasi dompet sebagai dana keluar (debit)
            $user->mutations()->create([
                'description' => 'Pengajuan Penarikan Dana (Withdrawal) sedang diproses',
                'type' => 'debit',
                'amount' => $amount
            ]);
        });

        return redirect()->back()->with('success', 'Pengajuan penarikan dana sebesar Rp ' . number_format($amount, 0, ',', '.') . ' berhasil dikirim! Saldo Anda telah terpotong dan sedang menunggu transfer verifikasi dari Admin Pusat.');
    }
}