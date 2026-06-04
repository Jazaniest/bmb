@extends('layouts.dashboard')

@section('title', 'Dashboard Pusat - Manajemen Admin')

@section('content')
@include('components.toast-alert')

<div class="space-y-6">

    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Ringkasan Operasional</h2>
            <p class="text-xs text-slate-500 mt-0.5">Selamat datang kembali. Berikut kondisi jaringan per hari ini.</p>
        </div>
        <div class="text-xxs font-mono text-slate-400 shrink-0">
            {{ now()->translatedFormat('l, d F Y • H:i') }} WIB
        </div>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Card 1: Total Agen Aktif --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs p-5 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Agen Aktif</span>
                <div class="w-8 h-8 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600">
                    <i class="ph ph-users-three text-base"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-800 leading-none">{{ number_format($stats['total_active_agents']) }}</div>
                <p class="text-xxs text-slate-400 mt-1">Mitra jaringan terverifikasi</p>
            </div>
            <div class="pt-2 border-t border-slate-100 flex items-center gap-1 text-xxs font-semibold text-amber-600">
                <i class="ph ph-clock text-sm"></i>
                {{ $stats['pending_agents'] }} pending verifikasi
            </div>
        </div>

        {{-- Card 2: Total Komisi Terdistribusi --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs p-5 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Komisi Distribusi</span>
                <div class="w-8 h-8 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600">
                    <i class="ph ph-chart-line-up text-base"></i>
                </div>
            </div>
            <div>
                <div class="text-lg font-black text-slate-800 leading-none">
                    Rp {{ number_format($stats['total_commission_distributed'], 0, ',', '.') }}
                </div>
                <p class="text-xxs text-slate-400 mt-1">Total bonus unilevel tersalur</p>
            </div>
            <div class="pt-2 border-t border-slate-100 flex items-center gap-1 text-xxs font-semibold text-violet-600">
                <i class="ph ph-network text-sm"></i>
                Semua tingkat jaringan
            </div>
        </div>

        {{-- Card 3: Pendapatan Biaya Daftar --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs p-5 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Fee Pendaftaran</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="ph ph-money-wavy text-base"></i>
                </div>
            </div>
            <div>
                <div class="text-lg font-black text-slate-800 leading-none">
                    Rp {{ number_format($stats['total_registration_income'], 0, ',', '.') }}
                </div>
                <p class="text-xxs text-slate-400 mt-1">Dari {{ $stats['total_approved_agents'] }} aktivasi disetujui</p>
            </div>
            <div class="pt-2 border-t border-slate-100 flex items-center gap-1 text-xxs font-semibold text-emerald-600">
                <i class="ph ph-arrow-circle-down text-sm"></i>
                Masuk ke kas pusat
            </div>
        </div>

        {{-- Card 4: Penarikan Dana --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs p-5 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Penarikan Dana</span>
                <div class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                    <i class="ph ph-arrows-out-line-horizontal text-base"></i>
                </div>
            </div>
            <div>
                <div class="text-lg font-black text-slate-800 leading-none">
                    Rp {{ number_format($stats['total_withdrawal_pending_amount'], 0, ',', '.') }}
                </div>
                <p class="text-xxs text-slate-400 mt-1">Nominal menunggu transfer</p>
            </div>
            <div class="pt-2 border-t border-slate-100 flex items-center gap-1 text-xxs font-semibold text-rose-500">
                <i class="ph ph-clock text-sm"></i>
                {{ $stats['total_withdrawal_pending'] }} permintaan pending
            </div>
        </div>

    </div>

    {{-- ===== ANTREAN TERBARU (2 kolom) ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Widget Agen Pending Terbaru --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs overflow-hidden flex flex-col">
            <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                    </span>
                    <h4 class="text-xs font-bold text-slate-700">Antrean Verifikasi Agen</h4>
                </div>
                <a href="{{ url('/admin/agents/pending') }}" 
                   class="text-xxs font-bold text-teal-600 hover:text-teal-700 flex items-center gap-0.5">
                    Lihat Semua <i class="ph ph-arrow-right text-sm"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100 flex-1">
                @forelse($recentPendingAgents as $agent)
                <div class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50/50 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-black text-xs shrink-0">
                        {{ strtoupper(substr($agent['name'], 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-slate-800 text-xs truncate">{{ $agent['name'] }}</div>
                        <div class="text-xxs text-slate-400 font-mono">KKB-{{ $agent['id'] }} • {{ $agent['created_at'] }}</div>
                    </div>
                    <a href="{{ url('/admin/agents/pending') }}" 
                       class="shrink-0 text-xxs font-bold text-amber-700 bg-amber-50 border border-amber-100 px-2 py-1 rounded-lg hover:bg-amber-100 transition-colors">
                        Review
                    </a>
                </div>
                @empty
                <div class="py-10 text-center text-slate-400">
                    <i class="ph ph-check-circle text-2xl text-slate-200 block mx-auto mb-1.5"></i>
                    <span class="text-xxs font-medium">Tidak ada antrean agen baru.</span>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Widget Penarikan Dana Pending Terbaru --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs overflow-hidden flex flex-col">
            <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                    <h4 class="text-xs font-bold text-slate-700">Antrean Pencairan Komisi</h4>
                </div>
                <a href="{{ url('/admin/withdrawals') }}" 
                   class="text-xxs font-bold text-teal-600 hover:text-teal-700 flex items-center gap-0.5">
                    Lihat Semua <i class="ph ph-arrow-right text-sm"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100 flex-1">
                @forelse($recentPendingWithdrawals as $wd)
                <div class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50/50 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center font-black text-xs shrink-0">
                        {{ strtoupper(substr($wd['agent_name'], 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-slate-800 text-xs truncate">{{ $wd['agent_name'] }}</div>
                        <div class="text-xxs text-slate-400 font-mono">{{ $wd['bank_name'] }} • {{ $wd['account_number'] }}</div>
                    </div>
                    <div class="shrink-0 text-right">
                        <div class="text-xs font-black text-slate-800">Rp {{ number_format($wd['amount'], 0, ',', '.') }}</div>
                        <a href="{{ url('/admin/withdrawals') }}" 
                           class="text-xxs font-bold text-rose-600 hover:underline">Proses</a>
                    </div>
                </div>
                @empty
                <div class="py-10 text-center text-slate-400">
                    <i class="ph ph-wallet text-2xl text-slate-200 block mx-auto mb-1.5"></i>
                    <span class="text-xxs font-medium">Tidak ada antrean penarikan dana.</span>
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ===== AKSES CEPAT ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ url('/admin/agents/pending') }}" 
           class="flex items-center gap-3 bg-white rounded-2xl border border-slate-200 shadow-xxs px-5 py-4 hover:border-teal-300 hover:shadow-sm transition-all group">
            <div class="w-9 h-9 rounded-xl bg-amber-50 group-hover:bg-amber-100 flex items-center justify-center text-amber-600 transition-colors">
                <i class="ph ph-user-check text-lg"></i>
            </div>
            <div>
                <div class="text-xs font-bold text-slate-700">Verifikasi Agen Baru</div>
                <div class="text-xxs text-slate-400">Setujui atau tolak pendaftaran</div>
            </div>
            <i class="ph ph-arrow-right text-slate-300 group-hover:text-teal-400 ml-auto transition-colors"></i>
        </a>

        <a href="{{ url('/admin/withdrawals') }}" 
           class="flex items-center gap-3 bg-white rounded-2xl border border-slate-200 shadow-xxs px-5 py-4 hover:border-teal-300 hover:shadow-sm transition-all group">
            <div class="w-9 h-9 rounded-xl bg-rose-50 group-hover:bg-rose-100 flex items-center justify-center text-rose-500 transition-colors">
                <i class="ph ph-bank text-lg"></i>
            </div>
            <div>
                <div class="text-xs font-bold text-slate-700">Proses Penarikan Dana</div>
                <div class="text-xxs text-slate-400">Konfirmasi transfer ke agen</div>
            </div>
            <i class="ph ph-arrow-right text-slate-300 group-hover:text-teal-400 ml-auto transition-colors"></i>
        </a>

        <a href="{{ url('/admin/bonus-settings') }}" 
           class="flex items-center gap-3 bg-white rounded-2xl border border-slate-200 shadow-xxs px-5 py-4 hover:border-teal-300 hover:shadow-sm transition-all group">
            <div class="w-9 h-9 rounded-xl bg-violet-50 group-hover:bg-violet-100 flex items-center justify-center text-violet-600 transition-colors">
                <i class="ph ph-sliders-horizontal text-lg"></i>
            </div>
            <div>
                <div class="text-xs font-bold text-slate-700">Atur Skema Bonus</div>
                <div class="text-xxs text-slate-400">Nominal komisi per level jaringan</div>
            </div>
            <i class="ph ph-arrow-right text-slate-300 group-hover:text-teal-400 ml-auto transition-colors"></i>
        </a>
    </div>

</div>
@endsection