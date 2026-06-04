@extends('layouts.dashboard')

@section('title', 'Persetujuan Penarikan Dana - Manajemen Pusat')

@section('content')
@include('components.toast-alert')

<div class="space-y-6">
    
    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Antrean Pencairan Komisi (Withdrawal)</h2>
            <p class="text-xs text-slate-500 mt-0.5">Proses permohonan transfer komisi bersih dari dompet digital para agen aktif.</p>
        </div>
        <div class="bg-rose-50 border border-rose-100 text-rose-800 text-xxs font-bold px-3 py-2 rounded-xl flex items-center gap-2 shrink-0 self-start sm:self-center shadow-xxs">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
            </span>
            {{ count($pendingWithdrawals) }} Permintaan Menunggu Transfer
        </div>
    </div>

    {{-- ===== TABEL ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 bg-slate-50/80 border-b border-slate-200/60 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Daftar Transaksi Keluar</h4>
                <p class="text-xxs text-slate-400 mt-0.5">Pastikan transfer manual ke rekening agen sukses dilakukan sebelum menekan Konfirmasi.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-200">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60 text-xxs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-6">Identitas Agen</th>
                        <th class="py-4 px-6">Detail Rekening Tujuan</th>
                        <th class="py-4 px-6">Nominal Penarikan</th>
                        <th class="py-4 px-6">Tanggal Pengajuan</th>
                        <th class="py-4 px-6 text-center">Aksi Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($pendingWithdrawals as $wd)
                    <tr class="hover:bg-slate-50/30 transition-colors">

                        {{-- Identitas Agen --}}
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-800 text-sm">{{ $wd['agent_name'] }}</div>
                            <div class="text-xxs text-slate-400 font-mono mt-1 bg-slate-100 inline-block px-1.5 py-0.5 rounded">ID: KKB-{{ $wd['user_id'] }}</div>
                        </td>

                        {{-- Rekening Tujuan --}}
                        <td class="py-4 px-6">
                            <div class="items-center gap-1.5 font-bold text-teal-700 bg-teal-50/60 px-2 py-0.5 rounded-md width-fit inline-block">
                                <i class="ph ph-bank text-xs"></i> {{ strtoupper($wd['bank_name']) }}
                            </div>
                            <div class="font-mono font-black text-slate-800 mt-1 tracking-wide text-sm">{{ $wd['account_number'] }}</div>
                            <div class="text-xxs text-slate-500 mt-0.5">a.n. {{ $wd['account_name'] }}</div>
                        </td>

                        {{-- Nominal --}}
                        <td class="py-4 px-6">
                            <div class="text-base font-black text-slate-800 tracking-tight">
                                Rp {{ number_format($wd['amount'], 0, ',', '.') }}
                            </div>
                            <span class="inline-block text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md mt-1 border border-slate-200/60 uppercase">
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
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xxs rounded-xl shadow-xxs transition-colors cursor-pointer">
                                        <i class="ph ph-check-circle text-sm"></i> Konfirmasi Transfer
                                    </button>
                                </form>

                                {{-- Reject --}}
                                <form action="{{ url('/admin/withdrawals/'.$wd['id'].'/reject') }}" method="POST"
                                    onsubmit="return confirm('Tolak penarikan dana ini? Saldo akan dikembalikan penuh ke dompet agen.')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-600 font-bold text-xxs rounded-xl transition-colors cursor-pointer">
                                        Tolak / Refund
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center text-slate-400">
                            <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center mx-auto mb-3 border border-slate-100 text-2xl">
                                <i class="ph ph-chart-bar-light"></i>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Antrean Bersih!</span>
                            <span class="text-xxs text-slate-400 mt-1 block">Tidak ada pengajuan pencairan dana komisi saat ini.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection