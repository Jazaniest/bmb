@extends('layouts.dashboard')

@section('title', 'Dashboard Agen - BMB Tour & Travel')

@section('content')
<!-- Memanggil Toast Alert Global untuk Notifikasi Flash -->
@include('components.toast-alert')

<div class="space-y-6 sm:space-y-8">
    <!-- 1. BANNER SALAM & REFERRAL LINK (Premium Dark Emerald Gradient) -->
    <div class="bg-linear-to-r from-[#041E1A] to-[#0A2E28] rounded-2xl p-6 text-white shadow-md flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 opacity-[0.04] pointer-events-none select-none">
            <i class="ph ph-airplane-takeoff text-[200px]"></i>
        </div>
        
        <div class="space-y-1 relative z-10">
            <h2 class="text-xl sm:text-2xl font-serif font-bold tracking-wide">Ahlan Wa Sahlan, {{ auth()->user()->name }}!</h2>
            <p class="text-xs text-teal-200/80 font-light">Mitra Resmi BMB Tour & Travel • ID Agen: <span class="font-mono font-bold text-amber-400">KKB-{{ str_pad(auth()->user()->id, 7, '0', STR_PAD_LEFT) }}</span></p>
        </div>

        <!-- SLOT LINK REFERRAL DENGAN JAVASCRIPT COPY BUTTON -->
        <div class="w-full xl:w-auto bg-white/5 backdrop-blur-xs p-3.5 rounded-xl border border-white/10 space-y-1.5 relative z-10 shrink-0">
            <span class="block text-[10px] font-bold uppercase tracking-widest text-teal-300">Link Syiar / Referral Anda</span>
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" id="referral-link" readonly 
                    value="{{ url('/register?ref=KKB-' . auth()->user()->id) }}" 
                    class="bg-slate-950/40 border border-teal-700/40 rounded-lg px-3 py-2 text-xs font-mono text-teal-200 w-full xl:w-64 focus:outline-hidden">
                <button onclick="copyReferralLink()" class="px-4 py-2 sm:py-0 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold rounded-lg flex items-center justify-center gap-1.5 transition-colors cursor-pointer shrink-0 shadow-xs">
                    <i id="copy-icon" class="ph ph-copy text-sm"></i>
                    <span id="copy-text">Salin Link</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 2. KARTU WIDGET FINANSIAL & JARINGAN (GRID ACCENT) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Kartu Saldo Aktif -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-xs flex items-center justify-between hover:border-slate-300 transition-all group">
            <div class="space-y-1.5">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Saldo Dompet Saat Ini</span>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Rp {{ number_format($walletBalance ?? 0, 0, ',', '.') }}</h3>
                <a href="{{ url('/agent/wallet') }}" class="inline-flex items-center text-xs font-bold text-teal-700 hover:text-teal-800 gap-1 pt-1 transition-colors">
                    Ajukan Penarikan <i class="ph ph-arrow-up-right text-xs transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                </a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 text-teal-700 flex items-center justify-center text-xl shrink-0">
                <i class="ph ph-wallet"></i>
            </div>
        </div>

        <!-- Kartu Total Bonus Didapat -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-xs flex items-center justify-between hover:border-slate-300 transition-all">
            <div class="space-y-1.5">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Akumulasi Komisi</span>
                <h3 class="text-xl sm:text-2xl font-bold text-teal-800 tracking-tight">Rp {{ number_format($totalEarned ?? 0, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-slate-400 font-light">Total komisi bersih sejak akun aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0">
                <i class="ph ph-hand-coins"></i>
            </div>
        </div>

        <!-- Kartu Total Jaringan Downline -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-xs flex items-center justify-between sm:col-span-2 lg:col-span-1 hover:border-slate-300 transition-all group">
            <div class="space-y-1.5">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Jamaah Jaringan</span>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">{{ $totalNetworkSize ?? 0 }} Orang</h3>
                <a href="{{ url('/agent/network') }}" class="inline-flex items-center text-xs font-bold text-teal-700 hover:text-teal-800 gap-1 pt-1 transition-colors">
                    Lihat Struktur Pohon <i class="ph ph-tree-structure text-xs transform group-hover:scale-110 transition-transform"></i>
                </a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-700 flex items-center justify-center text-xl shrink-0">
                <i class="ph ph-users-three"></i>
            </div>
        </div>
    </div>

    <!-- 3. INFORMASI LOGISTIK / ALUR PANDUAN PENTING -->
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xs p-5 sm:p-6">
        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-5 flex items-center gap-2">
            <i class="ph-bold ph-info text-teal-700 text-base"></i> Langkah Cepat Mengembangkan Syiar Umrah
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">
                <div class="w-7 h-7 bg-teal-800 text-white font-bold rounded-lg flex items-center justify-center text-xs">1</div>
                <h5 class="text-xs font-bold text-slate-800">Bagikan Link Referral</h5>
                <p class="text-[11px] text-slate-500 leading-normal font-light">Salin tautan di atas dan kirimkan ke keluarga, kerabat, atau jamaah yang ingin mendaftar keagenan.</p>
            </div>
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">
                <div class="w-7 h-7 bg-teal-800 text-white font-bold rounded-lg flex items-center justify-center text-xs">2</div>
                <h5 class="text-xs font-bold text-slate-800">Pantau Level Jaringan</h5>
                <p class="text-[11px] text-slate-500 leading-normal font-light">Gunakan menu <strong class="font-semibold text-slate-700">Pohon Jaringan</strong> untuk mengamati perkembangan downline dari Level 1 hingga tingkat 10.</p>
            </div>
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">
                <div class="w-7 h-7 bg-teal-800 text-white font-bold rounded-lg flex items-center justify-center text-xs">3</div>
                <h5 class="text-xs font-bold text-slate-800">Cairkan Komisi Instan</h5>
                <p class="text-[11px] text-slate-500 leading-normal font-light">Setiap bonus masuk secara real-time. Anda bisa mencairkannya kapan saja langsung ke rekening bank terdaftar.</p>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT UNTUK FITUR SATU-KLIK SALIN LINK -->
<script>
    function copyReferralLink() {
        const copyText = document.getElementById("referral-link");
        const icon = document.getElementById("copy-icon");
        const btnText = document.getElementById("copy-text");

        copyText.select();
        copyText.setSelectionRange(0, 99999); // Proteksi Perangkat Mobile

        navigator.clipboard.writeText(copyText.value);

        // Feedback Visual Sukses
        icon.classList.replace("ph-copy", "ph-check");
        btnText.innerText = "Tersalin!";
        
        setTimeout(() => {
            icon.classList.replace("ph-check", "ph-copy");
            btnText.innerText = "Salin Link";
        }, 2000);
    }
</script>
@endsection