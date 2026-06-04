<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BonusSetting;
use Illuminate\Support\Facades\DB;

class AdminAgentController extends Controller
{
    /**
     * DASHBOARD UTAMA ADMIN
     * Route: GET /admin/dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_active_agents'            => User::where('role', 'agent')->where('status', 'active')->count(),
            'pending_agents'                 => User::where('role', 'agent')->where('status', 'pending')->count(),
            'total_approved_agents'          => User::where('role', 'agent')->where('status', 'active')->count(),
            'total_commission_distributed'   => DB::table('transactions')->where('type', 'credit')->sum('amount') ?? 0,
            'total_registration_income'      => 0, // Sesuaikan jika ada tabel fee/payment
            'total_withdrawal_pending_amount'=> DB::table('withdrawals')->where('status', 'pending')->sum('amount') ?? 0,
            'total_withdrawal_pending'       => DB::table('withdrawals')->where('status', 'pending')->count(),
        ];

        $recentPendingAgents = User::where('role', 'agent')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($u) => [
                'id'         => $u->id,
                'name'       => $u->name,
                'created_at' => $u->created_at->format('d M Y'),
            ])
            ->toArray();

        $recentPendingWithdrawals = DB::table('withdrawals')
            ->join('users', 'withdrawals.user_id', '=', 'users.id')
            ->where('withdrawals.status', 'pending')
            ->latest('withdrawals.created_at')
            ->take(5)
            ->select('withdrawals.id', 'users.name as agent_name', 'withdrawals.bank_name', 'withdrawals.account_number', 'withdrawals.amount')
            ->get()
            ->map(fn($wd) => (array) $wd)
            ->toArray();

        return view('admin.dashboard', compact('stats', 'recentPendingAgents', 'recentPendingWithdrawals'));
    }

    /**
     * Tampilkan Halaman Antrean Agen Berstatus Pending (Verifikasi Admin)
     * Route: GET /admin/agents/pending
     */
    public function pendingIndex()
    {
        $pendingAgents = User::where('role', 'agent')
                            ->where('status', 'pending')
                            ->latest()
                            ->get();

        return view('admin.agents.pending', compact('pendingAgents'));
    }

    /**
     * Memproses Persetujuan Aktivasi Agen Baru & Distribusi Komisi Berjenjang
     * Route: POST /admin/agents/{id}/approve
     */
    public function approveAgent($id)
    {
        $agent = User::where('role', 'agent')->where('status', 'pending')->findOrFail($id);

        DB::beginTransaction();

        try {
            $agent->update([
                'status'             => 'active',
                'email_verified_at'  => now(),
            ]);

            // Jalankan mesin distribusi komisi berbasis pengaturan dinamis database
            $this->distributeUnilevelBonus($agent);

            DB::commit();
            return redirect()->back()->with('success', 'Akun Agen ' . $agent->name . ' berhasil diaktifkan dan bonus komisi jaringan telah didistribusikan secara real-time!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Memproses Penolakan Aktivasi Calon Agen
     * Route: POST /admin/agents/{id}/reject
     */
    public function rejectAgent($id)
    {
        $agent = User::where('role', 'agent')->where('status', 'pending')->findOrFail($id);
        $agent->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Pendaftaran agen ' . $agent->name . ' telah ditolak.');
    }

    /**
     * Tampilkan Halaman Pengaturan Komisi Unilevel
     * Route: GET /admin/bonus-settings
     */
    public function bonusIndex()
    {
        $bonusSettings = BonusSetting::orderBy('level', 'asc')->get();
        return view('admin.bonus.settings', compact('bonusSettings'));
    }

    /**
     * Memproses Pembaruan Massal Nominal Komisi Unilevel
     * Route: POST /admin/bonus-settings/update
     */
    public function updateBonus(Request $request)
    {
        $request->validate([
            'amounts'   => 'required|array',
            'amounts.*' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->amounts as $level => $amount) {
                BonusSetting::where('level', $level)->update([
                    'amount'     => $amount,
                    'updated_at' => now(),
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Konfigurasi skema bonus unilevel 10 tingkat berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui konfigurasi: ' . $e->getMessage());
        }
    }

    /**
     * HELPER: Logika inti pembagian bonus unilevel dinamis 10 tingkat dari database
     */
    private function distributeUnilevelBonus(User $agent)
    {
        $currentSponsorId = $agent->sponsor_id;
        $currentLevel     = 1;

        // Optimasi: ambil semua pengaturan bonus sekaligus (key-value: level => amount)
        $bonusRules = BonusSetting::pluck('amount', 'level')->toArray();

        while ($currentSponsorId !== null && $currentLevel <= 10) {

            $sponsor = User::find($currentSponsorId);

            if (!$sponsor) break;

            if ($sponsor->status === 'active') {

                $bonusAmount = $bonusRules[$currentLevel] ?? 0;

                $description = $currentLevel === 1
                    ? "Bonus Rekrutmen Langsung dari Agen Baru: " . $agent->name
                    : "Bonus Kedalaman Generasi (Level " . $currentLevel . ") dari Agen: " . $agent->name;

                if ($bonusAmount > 0) {
                    $sponsor->increment('balance', $bonusAmount);

                    $sponsor->transactions()->create([
                        'description' => $description,
                        'type'        => 'credit',
                        'amount'      => $bonusAmount,
                    ]);
                }
            }

            $currentSponsorId = $sponsor->sponsor_id;
            $currentLevel++;
        }
    }
}