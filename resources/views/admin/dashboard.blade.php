@extends('layouts.dashboard')

@section('title', 'Dashboard Pusat - Manajemen Admin')

@section('content')
@include('components.toast-alert')

<div class="space-y-6">

    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Ringkasan Operasional</h2>
            <p class="text-xs text-slate-500 mt-0.5">Selamat datang kembali. Berikut kondisi jaringan per hari ini.</p>
        </div>
        <div class="text-xxs font-mono text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100 shrink-0 self-start sm:self-center">
            <i class="ph ph-calendar-blank mr-1"></i> {{ now()->translatedFormat('l, d F Y • H:i') }} WIB
        </div>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Card 1: Total Agen Aktif --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 flex flex-col justify-between gap-4 hover:shadow-md hover:border-slate-300 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Agen Aktif</span>
                <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-all duration-300">
                    <i class="ph ph-users-three text-lg"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-800 tracking-tight leading-none">{{ number_format($stats['total_active_agents']) }}</div>
                <p class="text-xxs text-slate-400 mt-1.5">Mitra jaringan terverifikasi</p>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xxs font-semibold text-amber-600">
                <i class="ph ph-clock-counter-clockwise text-sm animate-pulse"></i>
                {{ $stats['pending_agents'] }} pending verifikasi
            </div>
        </div>

        {{-- Card 2: Total Komisi Terdistribusi --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 flex flex-col justify-between gap-4 hover:shadow-md hover:border-slate-300 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Komisi Distribusi</span>
                <div class="w-9 h-9 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center group-hover:bg-violet-600 group-hover:text-white transition-all duration-300">
                    <i class="ph ph-chart-line-up text-lg"></i>
                </div>
            </div>
            <div>
                <div class="text-xl font-black text-slate-800 tracking-tight leading-none truncate">
                    Rp {{ number_format($stats['total_commission_distributed'], 0, ',', '.') }}
                </div>
                <p class="text-xxs text-slate-400 mt-1.5">Total bonus unilevel tersalur</p>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xxs font-semibold text-violet-600">
                <i class="ph ph-network text-sm"></i>
                Semua tingkat jaringan
            </div>
        </div>

        {{-- Card 3: Pendapatan Biaya Daftar --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 flex flex-col justify-between gap-4 hover:shadow-md hover:border-slate-300 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Fee Pendaftaran</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <i class="ph ph-money-wavy text-lg"></i>
                </div>
            </div>
            <div>
                <div class="text-xl font-black text-slate-800 tracking-tight leading-none truncate">
                    Rp {{ number_format($stats['total_registration_income'], 0, ',', '.') }}
                </div>
                <p class="text-xxs text-slate-400 mt-1.5">Dari {{ $stats['total_approved_agents'] }} aktivasi disetujui</p>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xxs font-semibold text-emerald-600">
                <i class="ph ph-arrow-circle-down text-sm"></i>
                Masuk ke kas pusat
            </div>
        </div>

        {{-- Card 4: Penarikan Dana --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 flex flex-col justify-between gap-4 hover:shadow-md hover:border-slate-300 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Penarikan Dana</span>
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                    <i class="ph ph-arrows-out-line-horizontal text-lg"></i>
                </div>
            </div>
            <div>
                <div class="text-xl font-black text-slate-800 tracking-tight leading-none truncate">
                    Rp {{ number_format($stats['total_withdrawal_pending_amount'], 0, ',', '.') }}
                </div>
                <p class="text-xxs text-slate-400 mt-1.5">Nominal menunggu transfer</p>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xxs font-semibold text-rose-500">
                <i class="ph ph-clock text-sm animate-pulse"></i>
                {{ $stats['total_withdrawal_pending'] }} permintaan pending
            </div>
        </div>

    </div>

    {{-- ===== ANTREAN TERBARU (2 kolom) ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Widget Agen Pending Terbaru --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col">
            <div class="px-5 py-4 bg-slate-50/70 border-b border-slate-200/60 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                    </span>
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Antrean Verifikasi Agen</h4>
                </div>
                <a href="{{ url('/admin/agents/pending') }}" 
                   class="text-xxs font-bold text-teal-600 bg-teal-50 border border-teal-100 px-2.5 py-1 rounded-lg hover:bg-teal-600 hover:text-white transition-all duration-200 flex items-center gap-1">
                    Lihat Semua <i class="ph ph-arrow-right"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100 flex-1">
                @forelse($recentPendingAgents as $agent)
                <div class="flex items-center justify-between gap-3 px-5 py-3.5 hover:bg-slate-50/40 transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-linear-to-br from-amber-100 to-amber-200 text-amber-800 flex items-center justify-center font-black text-xs shrink-0 shadow-xxs">
                            {{ strtoupper(substr($agent['name'], 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="font-bold text-slate-800 text-xs truncate">{{ $agent['name'] }}</div>
                            <div class="text-xxs text-slate-400 font-mono mt-0.5">KKB-{{ $agent['id'] }} • {{ $agent['created_at'] }}</div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/agents/pending') }}" 
                       class="shrink-0 text-xxs font-bold text-amber-700 bg-amber-50 border border-amber-100 px-3 py-1.5 rounded-xl hover:bg-amber-600 hover:text-white hover:border-amber-600 transition-all duration-200">
                        Review
                    </a>
                </div>
                @empty
                <div class="py-12 text-center text-slate-400 flex flex-col items-center justify-center">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center mb-2.5 border border-slate-100">
                        <i class="ph ph-check-circle text-xl text-slate-400"></i>
                    </div>
                    <span class="text-xxs font-bold uppercase tracking-wider text-slate-400">Tidak ada antrean agen baru</span>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Widget Penarikan Dana Pending Terbaru --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col">
            <div class="px-5 py-4 bg-slate-50/70 border-b border-slate-200/60 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Antrean Pencairan Komisi</h4>
                </div>
                <a href="{{ url('/admin/withdrawals') }}" 
                   class="text-xxs font-bold text-teal-600 bg-teal-50 border border-teal-100 px-2.5 py-1 rounded-lg hover:bg-teal-600 hover:text-white transition-all duration-200 flex items-center gap-1">
                    Lihat Semua <i class="ph ph-arrow-right"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100 flex-1">
                @forelse($recentPendingWithdrawals as $wd)
                <div class="flex items-center justify-between gap-3 px-5 py-3.5 hover:bg-slate-50/40 transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-linear-to-br from-rose-100 to-rose-200 text-rose-700 flex items-center justify-center font-black text-xs shrink-0 shadow-xxs">
                            {{ strtoupper(substr($wd['agent_name'], 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="font-bold text-slate-800 text-xs truncate">{{ $wd['agent_name'] }}</div>
                            <div class="text-xxs text-slate-400 font-mono mt-0.5 truncate">{{ $wd['bank_name'] }} • {{ $wd['account_number'] }}</div>
                        </div>
                    </div>
                    <div class="shrink-0 text-right">
                        <div class="text-xs font-black text-slate-800">Rp {{ number_format($wd['amount'], 0, ',', '.') }}</div>
                        <a href="{{ url('/admin/withdrawals') }}" class="inline-block text-xxs font-bold text-rose-500 hover:text-rose-700 mt-0.5 transition-colors">
                            Proses <i class="ph ph-caret-right inline text-[10px]"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="py-12 text-center text-slate-400 flex flex-col items-center justify-center">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center mb-2.5 border border-slate-100">
                        <i class="ph ph-wallet text-xl text-slate-400"></i>
                    </div>
                    <span class="text-xxs font-bold uppercase tracking-wider text-slate-400">Tidak ada antrean penarikan dana</span>
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ===== AKSES CEPAT ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ url('/admin/agents/pending') }}" 
           class="flex items-center gap-4 bg-white rounded-2xl border border-slate-200 shadow-xs px-5 py-4 hover:border-teal-400 hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 rounded-xl bg-amber-50 group-hover:bg-amber-500 group-hover:text-white flex items-center justify-center text-amber-600 transition-all duration-300 shadow-xxs">
                <i class="ph ph-user-check text-xl"></i>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-bold text-slate-800 group-hover:text-teal-600 transition-colors">Verifikasi Agen Baru</div>
                <div class="text-xxs text-slate-400 truncate mt-0.5">Setujui atau tolak pendaftaran</div>
            </div>
            <i class="ph ph-arrow-right text-slate-300 group-hover:text-teal-500 group-hover:translate-x-1 transition-all"></i>
        </a>

        <a href="{{ url('/admin/withdrawals') }}" 
           class="flex items-center gap-4 bg-white rounded-2xl border border-slate-200 shadow-xs px-5 py-4 hover:border-teal-400 hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 rounded-xl bg-rose-50 group-hover:bg-rose-500 group-hover:text-white flex items-center justify-center text-rose-500 transition-all duration-300 shadow-xxs">
                <i class="ph ph-bank text-xl"></i>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-bold text-slate-800 group-hover:text-teal-600 transition-colors">Proses Penarikan Dana</div>
                <div class="text-xxs text-slate-400 truncate mt-0.5">Konfirmasi transfer ke agen</div>
            </div>
            <i class="ph ph-arrow-right text-slate-300 group-hover:text-teal-500 group-hover:translate-x-1 transition-all"></i>
        </a>

        <a href="{{ url('/admin/bonus-settings') }}" 
           class="flex items-center gap-4 bg-white rounded-2xl border border-slate-200 shadow-xs px-5 py-4 hover:border-teal-400 hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 rounded-xl bg-violet-50 group-hover:bg-violet-500 group-hover:text-white flex items-center justify-center text-violet-600 transition-all duration-300 shadow-xxs">
                <i class="ph ph-sliders-horizontal text-xl"></i>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-bold text-slate-800 group-hover:text-teal-600 transition-colors">Atur Skema Bonus</div>
                <div class="text-xxs text-slate-400 truncate mt-0.5">Nominal komisi per level jaringan</div>
            </div>
            <i class="ph ph-arrow-right text-slate-300 group-hover:text-teal-500 group-hover:translate-x-1 transition-all"></i>
        </a>
    </div>

</div>
@endsection