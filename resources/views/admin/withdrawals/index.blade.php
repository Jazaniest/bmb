@extends('layouts.dashboard')

@section('title', 'Persetujuan Penarikan Dana - Manajemen Pusat')

@section('content')
@include('components.toast-alert')

<div class="space-y-6">
    
    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Antrean Pencairan Komisi (Withdrawal)</h2>
            <p class="text-xs text-slate-500">Proses permohonan transfer komisi bersih dari dompet digital para agen aktif.</p>
        </div>
        <div class="bg-rose-50 border border-rose-100 text-rose-800 text-xxs font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shrink-0">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
            </span>
            {{ count($pendingWithdrawals) }} Permintaan Menunggu Transfer
        </div>
    </div>

    {{-- ===== TABEL ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs overflow-hidden">
        <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide">Daftar Transaksi Keluar</h4>
            <p class="text-xxs text-slate-400">Pastikan transfer manual ke rekening agen sukses dilakukan sebelum menekan Konfirmasi.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xxs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-6">Identitas Agen</th>
                        <th class="py-3.5 px-6">Detail Rekening Tujuan</th>
                        <th class="py-3.5 px-6">Nominal Penarikan</th>
                        <th class="py-3.5 px-6">Tanggal Pengajuan</th>
                        <th class="py-3.5 px-6 text-center">Aksi Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($pendingWithdrawals as $wd)
                    <tr class="hover:bg-slate-50/40 transition-colors">

                        {{-- Identitas Agen --}}
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-800 text-sm">{{ $wd['agent_name'] }}</div>
                            <div class="text-xxs text-slate-400 font-mono mt-0.5">ID: KKB-{{ $wd['user_id'] }}</div>
                        </td>

                        {{-- Rekening Tujuan --}}
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-1.5 font-bold text-teal-800">
                                <i class="ph ph-bank text-sm"></i> {{ $wd['bank_name'] }}
                            </div>
                            <div class="font-mono font-bold text-slate-800 mt-0.5 tracking-wide">{{ $wd['account_number'] }}</div>
                            <div class="text-xxs text-slate-400 mt-0.5">a.n. {{ $wd['account_name'] }}</div>
                        </td>

                        {{-- Nominal --}}
                        <td class="py-4 px-6">
                            <div class="text-base font-black text-slate-800">
                                Rp {{ number_format($wd['amount'], 0, ',', '.') }}
                            </div>
                            <span class="inline-block text-[10px] font-bold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded mt-0.5 uppercase">
                                Biaya Admin: Rp 0
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="py-4 px-6 font-mono text-xxs text-slate-400">
                            {{ $wd['created_at'] }}
                        </td>

                        {{-- Aksi --}}
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Approve --}}
                                <form action="{{ url('/admin/withdrawals/'.$wd['id'].'/approve') }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda sudah benar-benar mentransfer dana sebesar Rp {{ number_format($wd['amount'], 0, ',', '.') }} ke rekening tujuan?')">
                                    @csrf
                                    <button type="submit" class="h-8 px-3 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xxs rounded-lg transition-colors cursor-pointer flex items-center gap-1 pt-0.5">
                                        <i class="ph ph-check-square"></i> Konfirmasi Transfer
                                    </button>
                                </form>

                                {{-- Reject --}}
                                <form action="{{ url('/admin/withdrawals/'.$wd['id'].'/reject') }}" method="POST"
                                    onsubmit="return confirm('Tolak penarikan dana ini? Saldo akan dikembalikan penuh ke dompet agen.')">
                                    @csrf
                                    <button type="submit" class="h-8 px-3 bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-600 font-bold text-xxs rounded-lg transition-colors cursor-pointer pt-0.5">
                                        Tolak / Refund
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center text-slate-400">
                            <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center mx-auto mb-2 text-xl">
                                <i class="ph ph-wallet-light"></i>
                            </div>
                            <span class="text-xs font-medium">Bersih! Tidak ada antrean pengajuan penarikan dana hari ini.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection