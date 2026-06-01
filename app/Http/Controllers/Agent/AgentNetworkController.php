<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AgentNetworkController extends Controller
{
    /**
     * Mengambil struktur pohon jaringan downline (Genealogy Tree) maksimal 10 tingkat
     */
    public function getGenealogyTree(): JsonResponse
    {
        $currentAgent = auth()->user();

        // 1. Ambil semua downline yang memiliki ID agen ini di dalam 'path' mereka
        // Contoh query: WHERE path LIKE '1/%' OR path LIKE '%/1/%' OR path LIKE '%/1'
        $downlines = User::select('id', 'name', 'referral_code', 'sponsor_id', 'path', 'status', 'created_at')
            ->where(function ($query) use ($currentAgent) {
                $query->where('path', $currentAgent->id)
                        ->orWhere('path', 'LIKE', $currentAgent->id . '/%')
                        ->orWhere('path', 'LIKE', '%/' . $currentAgent->id . '/%')
                        ->orWhere('path', 'LIKE', '%/' . $currentAgent->id);
            })
            ->get();

        // 2. Format data awal agen saat ini sebagai akar pohon (Root)
        $tree = [
            'id' => $currentAgent->id,
            'name' => $currentAgent->name,
            'referral_code' => $currentAgent->referral_code,
            'status' => $currentAgent->status,
            'level' => 0,
            'children' => []
        ];

        // 3. Susun data downlines menjadi struktur pohon bertingkat (Maksimal 10 tingkat)
        $tree['children'] = $this->buildTree($downlines, $currentAgent->id, $currentAgent->id);

        return response()->json([
            'success' => true,
            'data' => $tree
        ], 200);
    }

    /**
     * Mengambil Ringkasan Statistik & Analisis Pertumbuhan Jaringan Agen
     */
    public function getNetworkSummary(): JsonResponse
    {
        $currentAgent = auth()->user();

        // 1. Ambil semua downline yang sah di bawah jaringan agen ini (seperti pada Bagian 1)
        $downlines = User::select('id', 'sponsor_id', 'path', 'status', 'created_at')
            ->where(function ($query) use ($currentAgent) {
                $query->where('path', $currentAgent->id)
                        ->orWhere('path', 'LIKE', $currentAgent->id . '/%')
                        ->orWhere('path', 'LIKE', '%/' . $currentAgent->id . '/%')
                        ->orWhere('path', 'LIKE', '%/' . $currentAgent->id);
            })
            ->get();

        // 2. HITUNG TOTAL KEPALA PER LEVEL (1 TINGKAT SAMPAI 10 TINGKAT)
        // Inisialisasi counter array untuk level 1 - 10 dengan nilai 0
        $levelCounts = array_fill(1, 10, 0);
        $totalActiveNetwork = 0;

        foreach ($downlines as $user) {
            // Kita bisa menghitung level user berdasarkan kedalaman string path-nya
            // Misal path Agen Utama = null (Root, level 0)
            // Path downline = "2" -> Level 1
            // Path downline = "2/3" -> Level 2, dst.
            
            $pathIds = explode('/', $user->path);
            
            // Cari posisi ID Agen Utama di dalam array path downline tersebut
            $agentPosition = array_search($currentAgent->id, $pathIds);

            if ($agentPosition !== false) {
                // Jarak level adalah selisih dari panjang total path dikurangi posisi Agen Utama
                $depth = count($pathIds) - ($agentPosition + 1);
                
                // Pastikan masuk ke rentang level 1 sampai 10
                if ($depth >= 1 && $depth <= 10) {
                    $levelCounts[$depth]++;
                    if ($user->status === 'active') {
                        $totalActiveNetwork++;
                    }
                }
            }
        }

        // Format data level agar siap dibaca oleh frontend
        $formattedLevels = [];
        foreach ($levelCounts as $level => $count) {
            $formattedLevels[] = [
                'level' => 'Level ' . $level,
                'total_members' => $count
            ];
        }

        // 3. HITUNG PERTUMBUHAN BULANAN (6 BULAN TERAKHIR)
        $monthlyGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $targetMonth = now()->subMonths($i);
            $monthLabel = $targetMonth->translatedFormat('F Y'); // Contoh: "Juni 2026"
            
            // Filter downline yang bergabung pada bulan dan tahun spesifik tersebut
            $countNewInMonth = $downlines->filter(function ($user) use ($targetMonth) {
                return $user->created_at->format('Y-m') === $targetMonth->format('Y-m');
            })->count();

            $monthlyGrowth[] = [
                'month' => $monthLabel,
                'new_members' => $countNewInMonth
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total_network_size' => $downlines->count(),
                'total_active_network' => $totalActiveNetwork,
                'breakdown_per_level' => $formattedLevels,
                'monthly_growth_analytics' => $monthlyGrowth
            ]
        ], 200);
    }

    /**
     * Fungsi rekursif pembantu untuk menyusun format nested array JSON
     */
    private function buildTree($users, $parentId, $rootId, $currentLevel = 1)
    {
        // Batasi kedalaman pohon jaringan hanya sampai maksimal 10 tingkat sesuai Skema Utama
        if ($currentLevel > 10) {
            return [];
        }

        $branch = [];

        // Cari user yang merupakan downline langsung (Level 1) dari parentId saat ini
        foreach ($users as $user) {
            if ($user->sponsor_id == $parentId) {
                
                // Rekursi untuk mencari anak-cucu (downline) di bawah user ini lagi
                $children = $this->buildTree($users, $user->id, $rootId, $currentLevel + 1);

                $node = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'referral_code' => $user->referral_code,
                    'status' => $user->status,
                    'level' => $currentLevel, // Mencatat posisi level (1 sampai 10)
                    'joined_at' => $user->created_at->format('Y-m-d'),
                ];

                if (!empty($children)) {
                    $node['children'] = $children;
                } else {
                    $node['children'] = [];
                }

                $branch[] = $node;
            }
        }

        return $branch;
    }
}