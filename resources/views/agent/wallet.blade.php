@extends('layouts.dashboard')

@section('title', 'Dompet & Komisi Agen - Kaukaba Tour & Travel')

@section('content')
<!-- Memanggil Toast Alert Global untuk Feedback Sukses/Gagal WD -->
@include('components.toast-alert')

<div class="space-y-6 sm:space-y-8">
    
    <!-- HEADER HALAMAN -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold font-serif text-slate-800 tracking-tight">Manajemen Keuangan & Komisi</h2>
            <p class="text-xs text-slate-500 font-light">Pantau akumulasi bonus syiar dan lakukan pencairan dana Anda.</p>
        </div>
        
        <!-- Info Ringkas Rekening Terdaftar (Adaptif Layar Kecil) -->
        <div class="bg-slate-100 border border-slate-200/80 rounded-xl px-4 py-2.5 flex items-center gap-3 self-start lg:self-auto">
            <div class="w-8 h-8 rounded-lg bg-teal-800 text-white flex items-center justify-center text-lg shrink-0 shadow-xs">
                <i class="ph ph-bank"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rekening Tujuan Pencairan</p>
                <p class="text-xs font-semibold text-slate-700 truncate">
                    {{ auth()->user()->bank_name ?? 'BSI' }} — <span class="font-mono text-slate-600">{{ auth()->user()->account_number ?? 'xxxx1234' }}</span>
                </p>
            </div>
        </div>
    </div>

    <!-- AREA KARTU SALDO & FORM PENCAIRAN (GRID) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- SISI KIRI: KARTU SALDO & FORM INTEGRASI WD -->
        <div class="space-y-6 lg:col-span-1">
            <!-- Kartu Dompet Utama -->
            <div class="bg-linear-to-br from-teal-700 to-teal-950 rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
                <div class="absolute right-0 bottom-0 opacity-[0.04] pointer-events-none translate-x-4 translate-y-4 select-none">
                    <i class="ph ph-wallet text-[150px]"></i>
                </div>
                <span class="text-xs font-bold text-teal-200/80 uppercase tracking-wider block">Saldo Siap Dicairkan</span>
                <h3 class="text-2xl sm:text-3xl font-bold mt-1 tracking-tight">Rp {{ number_format($walletBalance ?? 0, 0, ',', '.') }}</h3>
                <div class="mt-5 pt-4 border-t border-white/10 flex justify-between text-[10px] text-teal-200/70 font-light">
                    <span>Batas Minimal WD: <strong class="text-white font-semibold">Rp 50.000</strong></span>
                    <span>Admin: <strong class="text-emerald-400 font-semibold">Gratis</strong></span>
                </div>
            </div>

            <!-- Form Pengajuan Penarikan Dana (Withdrawal) -->
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/60 shadow-xs">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-4 flex items-center gap-1.5">
                    <i class="ph ph-hand-withdrawal text-teal-700 text-base"></i> Form Penarikan Dana
                </h4>
                <form action="{{ url('/agent/wallet/withdraw') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nominal Penarikan (Rp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-sm font-bold text-slate-400 pointer-events-none">Rp</span>
                            <input type="number" name="amount" required min="50000" max="{{ $walletBalance ?? 0 }}"
                                class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 focus:outline-hidden focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 focus:bg-white transition-all"
                                placeholder="Contoh: 500000">
                        </div>
                        <p class="text-[10px] text-slate-400 font-light mt-1">Dana dicairkan manual oleh tim keuangan ke rekening terdaftar Anda.</p>
                    </div>

                    <button type="submit" class="w-full h-11 bg-linear-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-950 text-white font-bold rounded-xl text-sm shadow-sm transition-all transform active:scale-[0.98] cursor-pointer flex items-center justify-center gap-1.5">
                        <i class="ph ph-paper-plane-tilt text-base"></i> Ajukan Pencairan Dana
                    </button>
                </form>
            </div>
        </div>

        <!-- SISI KANAN: TABEL MUTASI HISTORI BONUS (RESPONSIF MOBILE) -->
        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xs overflow-hidden lg:col-span-2 flex flex-col">
            <div class="p-4 sm:p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-1.5">
                    <i class="ph ph-clock-counter-clockwise text-teal-700 text-base"></i> Riwayat Mutasi Dompet
                </h4>
                <span class="text-[10px] font-medium bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full border border-slate-200/40">Real-time</span>
            </div>

            <!-- Wrapper Proteksi Scroll Horizontal -->
            <div class="w-full overflow-x-auto chunk-scroll">
                <table class="w-full text-left border-collapse min-w-125">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3.5 px-5 sm:px-6">Tanggal / Jam</th>
                            <th class="py-3.5 px-5 sm:px-6">Keterangan Transaksi</th>
                            <th class="py-3.5 px-5 sm:px-6 text-right">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @forelse($mutations ?? [] as $mutation)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="py-4 px-5 sm:px-6 font-mono text-[10px] text-slate-400 whitespace-nowrap">
                                {{ $mutation['created_at'] }}
                            </td>
                            <td class="py-4 px-5 sm:px-6">
                                <div class="font-semibold text-slate-800">{{ $mutation['description'] }}</div>
                                <div class="text-[10px] text-slate-400 font-light mt-0.5">Tipe: <span class="capitalize font-normal text-slate-500">{{ $mutation['type'] }}</span></div>
                            </td>
                            <td class="py-4 px-5 sm:px-6 text-right font-bold whitespace-nowrap {{ $mutation['type'] === 'credit' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $mutation['type'] === 'credit' ? '+' : '-' }}{{ number_format($mutation['amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-slate-400">
                                <i class="ph ph-folder-open text-4xl mb-2 text-slate-300 block"></i>
                                <span class="text-xs font-light">Belum ada riwayat mutasi transaksi di dompet Anda.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection