@extends('layouts.dashboard')

@section('title', 'Pohon Jaringan Agen - BMB Tour & Travel')

@section('content')
<div class="space-y-6">
    
    <!-- HEADER HALAMAN -->
    <div>
        <h2 class="text-xl font-bold font-serif text-slate-800 tracking-tight">Struktur Jaringan Kemitraan</h2>
        <p class="text-xs text-slate-500 font-light">Pantau pertumbuhan silsilah downline jamaah dan agen Anda hingga kedalaman 10 tingkat.</p>
    </div>

    <!-- 1. KARTU RINGKASAN TOTAL DOWNLINE PER LEVEL (FLUID GRID) -->
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xs p-5 sm:p-6">
        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-1.5">
            <i class="ph ph-chart-bar text-teal-700 text-base"></i> Rangkuman Kepala Per Tingkat (Level 1 - 10)
        </h4>
        <!-- Grid Ringkas: Minimum 3 kolom di HP terkecil agar hemat space -->
        <div class="grid grid-cols-3 sm:grid-cols-5 lg:grid-cols-10 gap-2 sm:gap-3 text-center">
            @for ($i = 1; $i <= 10; $i++)
                <div class="bg-slate-50 border border-slate-100 p-2 rounded-xl">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Lvl {{ $i }}</div>
                    <div class="text-sm font-bold text-slate-800 mt-0.5">
                        {{ $levelCounts['level_' . $i] ?? 0 }}
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <!-- 2. STRUKTUR DAFTAR RUNTUN (ACCORDION TREE) -->
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xs overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-slate-50/40">
            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-1.5">
                <i class="ph ph-tree-structure text-teal-700 text-base"></i> Eksplorasi Silsilah Keagenan
            </h4>
            <span class="text-[10px] font-medium text-slate-400">Klik baris nama untuk melihat susunan sub-downline</span>
        </div>

        <!-- Wadah Utama Pohon Runtut -->
        <div class="p-4 sm:p-6 space-y-3">
            @forelse($networkTree ?? [] as $lvl1)
                <!-- BLOK LEVEL 1 (Akar Utama) -->
                <div class="border border-slate-200/80 rounded-xl overflow-hidden">
                    <button onclick="toggleAccordion('item-{{ $lvl1['id'] }}')" class="w-full flex items-center justify-between p-3.5 sm:p-4 bg-slate-50/60 hover:bg-slate-100/60 transition-colors text-left cursor-pointer">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-teal-800 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-inner">L1</div>
                            <div class="min-w-0">
                                <h5 class="text-sm font-bold text-slate-800 truncate">{{ $lvl1['name'] }}</h5>
                                <p class="text-[10px] text-slate-400 font-mono">ID: KKB-{{ $lvl1['id'] }} • Reg: {{ $lvl1['join_date'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0 ml-2">
                            <span class="text-[10px] font-bold bg-teal-50 text-teal-800 border border-teal-100 px-2 py-0.5 rounded-md">
                                {{ count($lvl1['children'] ?? []) }} Downline
                            </span>
                            <i id="icon-item-{{ $lvl1['id'] }}" class="ph ph-caret-down text-slate-400 transition-transform duration-200 text-base"></i>
                        </div>
                    </button>

                    <!-- ISI RUNTUNAN LEVEL 2 -->
                    <div id="item-{{ $lvl1['id'] }}" class="hidden border-t border-slate-100 bg-white p-3 sm:p-4 space-y-2 pl-6 sm:pl-12 relative">
                        <!-- Garis vertikal penanda silsilah kiri -->
                        <div class="absolute left-3 sm:left-6 top-0 bottom-0 w-0.5 bg-slate-100"></div>

                        @forelse($lvl1['children'] ?? [] as $lvl2)
                            <!-- ITEM LEVEL 2 -->
                            <div class="border border-slate-100 rounded-lg overflow-hidden relative z-10">
                                <button onclick="toggleAccordion('item-{{ $lvl2['id'] }}')" class="w-full flex items-center justify-between p-3 bg-slate-50/40 hover:bg-slate-50 transition-colors text-left cursor-pointer">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-7 h-7 rounded-md bg-amber-600 text-white flex items-center justify-center font-bold text-[10px] shrink-0">L2</div>
                                        <div class="min-w-0">
                                            <h6 class="text-xs font-bold text-slate-700 truncate">{{ $lvl2['name'] }}</h6>
                                            <p class="text-[9px] text-slate-400 font-mono truncate">Sponsor: {{ $lvl1['name'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0 ml-2">
                                        <span class="text-[10px] font-medium text-slate-400">
                                            {{ count($lvl2['children'] ?? []) }} Gen 3
                                        </span>
                                        <i id="icon-item-{{ $lvl2['id'] }}" class="ph ph-caret-down text-slate-400 transition-transform duration-200 text-xs"></i>
                                    </div>
                                </button>

                                <!-- ISI RUNTUNAN LEVEL 3 -->
                                <div id="item-{{ $lvl2['id'] }}" class="hidden border-t border-slate-100 bg-slate-50/20 p-3 pl-5 sm:pl-6 space-y-1 relative">
                                    <div class="absolute left-2.5 sm:left-3 top-0 bottom-0 w-0.5 border-l border-dashed border-slate-200"></div>
                                    
                                    @forelse($lvl2['children'] ?? [] as $lvl3)
                                        <div class="flex items-center justify-between p-2 bg-white rounded border border-slate-100 text-[11px] relative z-10">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <div class="w-5 h-5 rounded bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-[9px] shrink-0">L3</div>
                                                <span class="font-medium text-slate-700 truncate">{{ $lvl3['name'] }}</span>
                                            </div>
                                            <span class="text-[10px] text-slate-400 font-mono ml-2 shrink-0">ID: {{ $lvl3['id'] }}</span>
                                        </div>
                                    @empty
                                        <p class="text-[10px] text-slate-400 italic p-1 font-light">Belum ada silsilah generasi Level 3 di bawah ini.</p>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-1 font-light">Belum memiliki downline di tingkat ini.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <!-- JIKA AGEN BARU SAMA SEKALI BELUM PUNYA DOWNLINE -->
                <div class="text-center py-16 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-300 flex items-center justify-center mx-auto mb-3 text-2xl border border-slate-100">
                        <i class="ph ph-tree-structure"></i>
                    </div>
                    <h5 class="text-sm font-bold text-slate-700">Pohon Jaringan Masih Kosong</h5>
                    <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto font-light leading-normal px-4">
                        Mulai bagikan link referral Anda di halaman depan untuk merekrut jamaah atau mitra baru.
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