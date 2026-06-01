@extends('layouts.dashboard')

@section('title', 'Pohon Jaringan Agen - Kaukaba Tour & Travel')

@section('content')
<div class="space-y-6">
    
    <!-- HEADER HALAMAN -->
    <div>
        <h2 class="text-xl font-black text-slate-800 tracking-tight">Struktur Jaringan Kemitraan</h2>
        <p class="text-xs text-slate-500">Pantau pertumbuhan silsilah downline jamaah dan agen Anda hingga kedalaman 10 tingkat.</p>
    </div>

    <!-- 1. KARTU RINGKASAN TOTAL DOWNLINE PER LEVEL -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs p-6">
        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-1.5">
            <i class="ph ph-chart-bar text-teal-700 text-base"></i> Rangkuman Kepala Per Tingkat (Level 1 - 10)
        </h4>
        <!-- Grid Ringkas untuk statistik level -->
        <div class="grid grid-cols-2 sm:grid-cols-5 lg:grid-cols-10 gap-3 text-center">
            @for ($i = 1; $i <= 10; $i++)
                <div class="bg-slate-50 border border-slate-100 p-2.5 rounded-xl">
                    <div class="text-xxs font-bold text-slate-400 uppercase">Lvl {{ $i }}</div>
                    <div class="text-sm font-black text-slate-800 mt-0.5">
                        {{ $levelCounts['level_' . $i] ?? 0 }}
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <!-- 2. STRUKTUR DAFTAR RUNTUN (ACCORDION TREE) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-1.5">
                <i class="ph ph-tree-structure text-teal-700 text-base"></i> Eksplorasi Silsilah Keagenan
            </h4>
            <span class="text-xxs font-medium text-slate-400">Klik nama untuk melihat downline di bawahnya</span>
        </div>

        <!-- Wadah Utama Pohon Runtut -->
        <div class="p-6 space-y-3">
            @forelse($networkTree ?? [] as $lvl1)
                <!-- BLOK LEVEL 1 (Akar Utama Anda) -->
                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <!-- Batang Utama Accordion Trigger -->
                    <button onclick="toggleAccordion('item-{{ $lvl1['id'] }}')" class="w-full flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100/70 transition-colors text-left cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-teal-700 text-white flex items-center justify-center font-bold text-xs">L1</div>
                            <div>
                                <h5 class="text-sm font-bold text-slate-800">{{ $lvl1['name'] }}</h5>
                                <p class="text-xxs text-slate-400 font-mono">ID: KKB-{{ $lvl1['id'] }} • Bergabung: {{ $lvl1['join_date'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xxs font-bold bg-teal-50 text-teal-700 border border-teal-100 px-2 py-0.5 rounded-md">
                                {{ count($lvl1['children'] ?? []) }} Downline
                            </span>
                            <i id="icon-item-{{ $lvl1['id'] }}" class="ph ph-caret-down text-slate-400 transition-transform duration-200 text-base"></i>
                        </div>
                    </button>

                    <!-- ISI RUNTUNAN LEVEL 2 (Collapsible Area) -->
                    <div id="item-{{ $lvl1['id'] }}" class="hidden border-t border-slate-100 bg-white p-4 space-y-2 pl-8 sm:pl-12 relative">
                        <!-- Garis penanda silsilah vertikal kiri -->
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-slate-100"></div>

                        @forelse($lvl1['children'] ?? [] as $lvl2)
                            <!-- ITEM LEVEL 2 -->
                            <div class="border border-slate-100 rounded-lg overflow-hidden">
                                <button onclick="toggleAccordion('item-{{ $lvl2['id'] }}')" class="w-full flex items-center justify-between p-3 bg-slate-50/50 hover:bg-slate-50 transition-colors text-left cursor-pointer">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-md bg-amber-600 text-white flex items-center justify-center font-bold text-xxs">L2</div>
                                        <div>
                                            <h6 class="text-xs font-bold text-slate-700">{{ $lvl2['name'] }}</h6>
                                            <p class="text-xxs text-slate-400 font-mono">Sponsor: {{ $lvl1['name'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xxs font-medium text-slate-400">
                                            {{ count($lvl2['children'] ?? []) }} Cucu
                                        </span>
                                        <i id="icon-item-{{ $lvl2['id'] }}" class="ph ph-caret-down text-slate-400 transition-transform duration-200 text-xs"></i>
                                    </div>
                                </button>

                                <!-- ISI RUNTUNAN LEVEL 3 (Dan seterusnya hingga Level 10 menggunakan pola serupa) -->
                                <div id="item-{{ $lvl2['id'] }}" class="hidden border-t border-slate-100 bg-slate-50/30 p-3 pl-6 space-y-1 relative">
                                    <div class="absolute left-3 top-0 bottom-0 w-0.5 bg-dashed border-l border-slate-200"></div>
                                    
                                    @forelse($lvl2['children'] ?? [] as $lvl3)
                                        <div class="flex items-center justify-between p-2 bg-white rounded border border-slate-100 text-xxs">
                                            <div class="flex items-center gap-2">
                                                <div class="w-5 h-5 rounded bg-slate-200 text-slate-600 flex items-center justify-center font-bold">L3</div>
                                                <span class="font-semibold text-slate-700">{{ $lvl3['name'] }}</span>
                                            </div>
                                            <span class="text-slate-400 font-mono">ID: KKB-{{ $lvl3['id'] }}</span>
                                        </div>
                                    @empty
                                        <p class="text-xxs text-slate-400 italic p-1">Belum ada silsilah generasi Level 3 di bawah ini.</p>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2">Belum memiliki downline di tingkat ini.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <!-- JIKA AGEN BARU SAMA SEKALI BELUM PUNYA DOWNLINE -->
                <div class="text-center py-16 border-2 border-dashed border-slate-200 rounded-xl text-slate-400">
                    <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="ph ph-tree-structure"></i>
                    </div>
                    <h5 class="text-sm font-bold text-slate-700">Pohon Jaringan Masih Kosong</h5>
                    <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">
                        Mulai bagikan link referral Anda di halaman depan untuk merekrut jamaah atau agen baru dan bangun tingkat generasi Anda.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- JAVASCRIPT ANIMASI ACCORDION BUKA-TUTUP LIST RUNTUN -->
<script>
    function toggleAccordion(id) {
        const content = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        
        if (content && icon) {
            // Cek apakah sedang tersembunyi
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    }
</script>
@endsection