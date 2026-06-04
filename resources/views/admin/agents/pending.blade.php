@extends('layouts.dashboard')

@section('title', 'Verifikasi Agen Baru - Manajemen Pusat')

@section('content')
@include('components.toast-alert')

<div class="space-y-6">
    
    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Persetujuan Aktivasi Kemitraan</h2>
            <p class="text-xs text-slate-500 mt-0.5">Validasi bukti pembayaran pendaftaran lisensi dari calon mitra/agen baru.</p>
        </div>
        <div class="bg-amber-50 border border-amber-200 text-amber-800 text-xxs font-bold px-3 py-2 rounded-xl flex items-center gap-2 shrink-0 self-start sm:self-center shadow-xxs">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            {{ count($pendingAgents ?? []) }} Menunggu Verifikasi
        </div>
    </div>

    {{-- ===== TABEL ANTREAN AGEN PENDING ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-225">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60 text-xxs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-6">Calon Agen</th>
                        <th class="py-4 px-6">Kontak & Rekening</th>
                        <th class="py-4 px-6">Sponsor / Referal</th>
                        <th class="py-4 px-6">Bukti Transfer</th>
                        <th class="py-4 px-6 text-center">Aksi Validasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($pendingAgents ?? [] as $agent)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        
                        {{-- Kolom Nama & Identitas --}}
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-800 text-sm">{{ $agent['name'] }}</div>
                            <div class="text-xxs text-slate-400 font-mono mt-1">ID: KKB-{{ $agent['id'] }} • Tgl: {{ $agent['created_at'] }}</div>
                        </td>
                        
                        {{-- Kolom Kontak & Rekening --}}
                        <td class="py-4 px-6 space-y-1">
                            <div class="flex items-center gap-1 text-slate-700 font-medium">
                                <i class="ph ph-whatsapp text-emerald-600 text-base"></i> {{ $agent['phone'] }}
                            </div>
                            <div class="text-xxs text-slate-500 font-mono bg-slate-50 border border-slate-100 px-2 py-1 rounded-md inline-block uppercase tracking-wide">
                                {{ strtoupper($agent['bank_name']) }} — {{ $agent['account_number'] }} <span class="text-slate-400 block sm:inline sm:ml-1">(a.n {{ $agent['account_name'] }})</span>
                            </div>
                        </td>
                        
                        {{-- Kolom Atasan / Sponsor --}}
                        <td class="py-4 px-6">
                            @if($agent['sponsor_name'])
                                <div class="font-bold text-slate-700 text-xs">{{ $agent['sponsor_name'] }}</div>
                                <div class="text-xxs text-slate-400 font-mono mt-0.5">ID: KKB-{{ $agent['sponsor_id'] }}</div>
                            @else
                                <span class="text-[10px] font-bold bg-slate-100 text-slate-400 border border-slate-200/50 px-2 py-0.5 rounded-md uppercase">Tanpa Sponsor (Pusat)</span>
                            @endif
                        </td>
                        
                        {{-- Kolom Pratinjau Gambar Bukti Transfer --}}
                        <td class="py-4 px-6">
                            <button onclick="openReceiptModal('{{ $agent['receipt_url'] }}', '{{ $agent['name'] }}')" 
                                class="inline-flex items-center gap-1.5 text-xxs font-bold text-teal-700 bg-teal-50 border border-teal-100 px-3 py-1.5 rounded-xl hover:bg-teal-600 hover:text-white transition-all duration-200 cursor-pointer shadow-xxs">
                                <i class="ph ph-image text-sm"></i> Lihat Bukti
                            </button>
                        </td>
                        
                        {{-- Kolom Tombol Eksekusi --}}
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Form Approve --}}
                                <form action="{{ url('/admin/agents/'.$agent['id'].'/approve') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin data transfer pendaftaran ini valid dan ingin mengaktifkan akun agen ini?')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xxs rounded-xl transition-colors cursor-pointer shadow-xxs">
                                        Setujui
                                    </button>
                                </form>
                                {{-- Form Reject --}}
                                <form action="{{ url('/admin/agents/'.$agent['id'].'/reject') }}" method="POST" onsubmit="return confirm('Tolak pendaftaran akun ini?')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-600 font-bold text-xxs rounded-xl transition-colors cursor-pointer">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center text-slate-400">
                            <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center mx-auto mb-3 border border-slate-100 text-2xl">
                                <i class="ph ph-user-list-light"></i>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Antrean Kosong</span>
                            <span class="text-xxs text-slate-400 mt-1 block">Tidak ada berkas aktivasi kemitraan baru yang pending saat ini.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ===== MODAL LIGHTBOX BUKTI TRANSFER ===== --}}
<div id="receipt-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs items-center justify-center p-4 transition-all duration-300">
    <div class="relative bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-100 transform transition-all scale-95 opacity-0 duration-300" id="modal-card">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Pratinjau Bukti Pembayaran</h3>
                <p id="modal-agent-name" class="text-xxs text-slate-500 font-medium mt-0.5"></p>
            </div>
            <button onclick="closeReceiptModal()" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-slate-600 flex items-center justify-center transition-colors cursor-pointer">
                <i class="ph ph-x text-base font-bold"></i>
            </button>
        </div>
        <div class="p-6 bg-slate-100 flex justify-center max-h-[70vh] overflow-y-auto">
            <img id="modal-image" src="" alt="Bukti Transfer" class="max-w-full h-auto rounded-xl shadow-xs border border-white">
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button onclick="closeReceiptModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xxs rounded-xl transition-colors cursor-pointer">
                Tutup Dokumen
            </button>
        </div>
    </div>
</div>

{{-- ===== JAVASCRIPT MODAL LOGIC ===== --}}
<script>
    function openReceiptModal(imageUrl, agentName) {
        const modal = document.getElementById('receipt-modal');
        const card = document.getElementById('modal-card');
        
        document.getElementById('modal-image').src = imageUrl;
        document.getElementById('modal-agent-name').innerText = "Calon Agen: " + agentName;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Animasi transisi masuk halus
        setTimeout(() => {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeReceiptModal() {
        const modal = document.getElementById('receipt-modal');
        const card = document.getElementById('modal-card');
        
        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.getElementById('modal-image').src = "";
        }, 200);
    }
    
    // Klik area luar modal untuk menutup otomatis
    document.getElementById('receipt-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReceiptModal();
        }
    });
</script>
@endsection