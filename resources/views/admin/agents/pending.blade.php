@extends('layouts.dashboard')

@section('title', 'Verifikasi Agen Baru - Manajemen Pusat')

@section('content')
<!-- Memanggil Toast Alert Global untuk Feedback Aksi Validasi -->
@include('components.toast-alert')

<div class="space-y-6">
    
    <!-- HEADER HALAMAN -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Persetujuan Aktivasi Kemitraan</h2>
            <p class="text-xs text-slate-500">Validasi bukti pembayaran pendaftaran lisensi dari calon mitra/agen baru.</p>
        </div>
        <div class="bg-amber-50 border border-amber-200 text-amber-800 text-xxs font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shrink-0">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            {{ count($pendingAgents ?? []) }} Menunggu Verifikasi
        </div>
    </div>

    <!-- TABEL ANTREAN AGEN PENDING -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xxs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-6">Calon Agen</th>
                        <th class="py-3.5 px-6">Kontak & Rekening</th>
                        <th class="py-3.5 px-6">Sponsor / Referal</th>
                        <th class="py-3.5 px-6">Bukti Transfer</th>
                        <th class="py-3.5 px-6 text-center">Aksi Validasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($pendingAgents ?? [] as $agent)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        <!-- Kolom Nama & Identitas -->
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-800 text-sm">{{ $agent['name'] }}</div>
                            <div class="text-xxs text-slate-400 font-mono mt-0.5">ID: KKB-{{ $agent['id'] }} • Tgl Daftar: {{ $agent['created_at'] }}</div>
                        </td>
                        <!-- Kolom Kontak & Rekening -->
                        <td class="py-4 px-6 space-y-0.5">
                            <div class="flex items-center gap-1 text-slate-700">
                                <i class="ph ph-whatsapp text-emerald-600 text-sm"></i> {{ $agent['phone'] }}
                            </div>
                            <div class="text-xxs text-slate-400 font-mono uppercase">
                                {{ $agent['bank_name'] }} — {{ $agent['account_number'] }} (a.n {{ $agent['account_name'] }})
                            </div>
                        </td>
                        <!-- Kolom Atasan / Sponsor -->
                        <td class="py-4 px-6">
                            @if($agent['sponsor_name'])
                                <div class="font-semibold text-slate-700">{{ $agent['sponsor_name'] }}</div>
                                <div class="text-xxs text-slate-400 font-mono">ID Sponsor: KKB-{{ $agent['sponsor_id'] }}</div>
                            @else
                                <span class="text-xxs font-medium bg-slate-100 text-slate-400 px-2 py-0.5 rounded-md">Tanpa Sponsor (Pusat)</span>
                            @endif
                        </td>
                        <!-- Kolom Pratinjau Gambar Bukti Transfer -->
                        <td class="py-4 px-6">
                            <button onclick="openReceiptModal('{{ $agent['receipt_url'] }}', '{{ $agent['name'] }}')" 
                                class="inline-flex items-center gap-1 text-xxs font-bold text-teal-700 hover:text-teal-800 bg-teal-50 border border-teal-100 px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer">
                                <i class="ph ph-image text-sm"></i> Lihat Bukti
                            </button>
                        </td>
                        <!-- Kolom Tombol Eksekusi -->
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Form Approve -->
                                <form action="{{ url('/admin/agents/'.$agent['id'].'/approve') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin data transfer pendaftaran ini valid dan ingin mengaktifkan akun agen ini?')">
                                    @csrf
                                    <button type="submit" class="h-8 px-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xxs rounded-lg transition-colors cursor-pointer pt-0.5">
                                        Setujui
                                    </button>
                                </form>
                                <!-- Form Reject -->
                                <form action="{{ url('/admin/agents/'.$agent['id'].'/reject') }}" method="POST" onsubmit="return confirm('Tolak pendaftaran akun ini?')">
                                    @csrf
                                    <button type="submit" class="h-8 px-3 bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-600 font-bold text-xxs rounded-lg transition-colors cursor-pointer pt-0.5">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center text-slate-400">
                            <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center mx-auto mb-2 text-xl">
                                <i class="ph ph-check-square"></i>
                            </div>
                            <span class="text-xs font-medium">Sip! Tidak ada antrean pendaftaran agen baru yang pending saat ini.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- COMPONENT MODAL POPUP PREVIEW BUKTI TRANSFER -->
<!-- <div id="receipt-modal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-xl overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
        <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <div>
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide">Bukti Transfer Pendaftaran</h4>
                <p id="modal-agent-name" class="text-xxs text-slate-500 font-medium mt-0.5"></p>
            </div>
            <button onclick="closeReceiptModal()" class="w-7 h-7 text-slate-400 hover:text-slate-600 rounded-lg bg-white border border-slate-200 shadow-xxs flex items-center justify-center cursor-pointer">
                <i class="ph ph-x text-base"></i>
            </button>
        </div>
        <div class="p-6 bg-slate-900 flex justify-center items-center max-h-100 overflow-y-auto">
            <img id="modal-image" src="" alt="Bukti Pembayaran" class="max-w-full h-auto rounded-lg shadow-md object-contain">
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button onclick="closeReceiptModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xxs font-bold rounded-xl transition-colors cursor-pointer">
                Tutup Pratinjau
            </button>
        </div>
    </div>
</div> -->

<!-- JAVASCRIPT MODAL LOGIC -->
<script>
    function openReceiptModal(imageUrl, agentName) {
        document.getElementById('modal-image').src = imageUrl;
        document.getElementById('modal-agent-name').innerText = "Calon Agen: " + agentName;
        // document.getElementById('receipt-modal').classList.remove('hidden');
    }

    function closeReceiptModal() {
        // document.getElementById('receipt-modal').classList.add('hidden');
        document.getElementById('modal-image').src = "";
    }
</script>
@endsection