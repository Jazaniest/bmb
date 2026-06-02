@extends('layouts.dashboard')

@section('title', 'Dashboard Agen - Kaukaba Tour & Travel')

@section('content')
<!-- Memanggil Toast Alert Global untuk Notifikasi Flash -->
@include('components.toast-alert')

<div class="space-y-8">
    <!-- 1. BANNER SALAM & UTING REFERRAL TRADING -->
    <div class="bg-linear-to-r from-teal-800 to-teal-950 rounded-2xl p-6 text-white shadow-xs flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 opacity-10 pointer-events-none">
            <i class="ph ph-airplane-takeoff text-[200px]"></i>
        </div>
        
        <div class="space-y-1 relative z-10">
            <h2 class="text-xl sm:text-2xl font-black tracking-tight">Ahlan Wa Sahlan, {{ auth()->user()->name }}!</h2>
            <p class="text-xs text-teal-200">Mitra Resmi Kaukaba Tour & Travel • ID Agen: <span class="font-mono font-bold text-amber-400">KKB-{{ str_pad(auth()->user()->id, 7, '0', STR_PAD_LEFT) }}</span></p>
        </div>

        <!-- SLOT LINK REFERRAL DENGAN JAVASCRIPT COPY BUTTON -->
        <div class="w-full md:w-auto bg-white/10 backdrop-blur-xs p-3 rounded-xl border border-white/10 space-y-1.5 relative z-10 shrink-0">
            <span class="block text-xxs font-bold uppercase tracking-wider text-teal-300">Link Syiar / Referral Anda</span>
            <div class="flex gap-2">
                <input type="text" id="referral-link" readonly 
                    value="{{ url('/register?ref=KKB-' . auth()->user()->id) }}" 
                    class="bg-slate-900/40 border border-teal-700/50 rounded-lg px-3 py-1.5 text-xs font-mono text-teal-200 w-full sm:w-64 focus:outline-hidden">
                <button onclick="copyReferralLink()" class="px-3 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold rounded-lg flex items-center gap-1 transition-colors cursor-pointer shrink-0">
                    <i id="copy-icon" class="ph ph-copy text-sm"></i>
                    <span id="copy-text">Salin</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 2. KARTU WIDGET FINANSIAL & JARINGSAN (GRID) -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Kartu Saldo Aktif -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xxs flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Saldo Dompet Saat Ini</span>
                <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($walletBalance ?? 0, 0, ',', '.') }}</h3>
                <a href="{{ url('/agent/wallet') }}" class="inline-flex items-center text-xs font-bold text-teal-700 hover:text-teal-800 hover:underline gap-1 pt-1">
                    Ajukan Penarikan <i class="ph ph-arrow-up-right"></i>
                </a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 text-teal-700 flex items-center justify-center text-2xl shrink-0">
                <i class="ph ph-wallet"></i>
            </div>
        </div>

        <!-- Kartu Total Bonus Didapat -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xxs flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Akumulasi Komisi</span>
                <h3 class="text-2xl font-black text-teal-800">Rp {{ number_format($totalEarned ?? 0, 0, ',', '.') }}</h3>
                <p class="text-xxs text-slate-400">Total komisi bersih sejak akun aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-center text-2xl shrink-0">
                <i class="ph ph-hand-coins"></i>
            </div>
        </div>

        <!-- Kartu Total Jaringan Downline -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xxs flex items-center justify-between sm:col-span-2 lg:col-span-1">
            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Jamaah Jaringan</span>
                <h3 class="text-2xl font-black text-slate-800">{{ $totalNetworkSize ?? 0 }} Orang</h3>
                <a href="{{ url('/agent/network') }}" class="inline-flex items-center text-xs font-bold text-teal-700 hover:text-teal-800 hover:underline gap-1 pt-1">
                    Lihat Struktur Pohon <i class="ph ph-tree-structure"></i>
                </a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-700 flex items-center justify-center text-2xl shrink-0">
                <i class="ph ph-users-three"></i>
            </div>
        </div>
    </div>

    <!-- 3. INFORMASI LOGISTIK / ALUR PANDUAN PENTING -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xxs p-6">
        <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-4 flex items-center gap-2">
            <i class="ph-bold ph-info text-teal-700 text-lg"></i> Langkah Cepat Mengembangkan Syiar Umrah
        </h4>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">
                <div class="w-7 h-7 bg-teal-700 text-white font-bold rounded-lg flex items-center justify-center text-xs">1</div>
                <h5 class="text-xs font-bold text-slate-800">Bagikan Link Referral</h5>
                <p class="text-xxs text-slate-500 leading-normal">Salin tautan di atas dan kirimkan ke keluarga, kerabat, atau jamaah yang ingin mendaftar agen maupun mendaftar paket travel.</p>
            </div>
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">
                <div class="w-7 h-7 bg-teal-700 text-white font-bold rounded-lg flex items-center justify-center text-xs">2</div>
                <h5 class="text-xs font-bold text-slate-800">Pantau Level Jaringan</h5>
                <p class="text-xxs text-slate-500 leading-normal">Gunakan menu **Pohon Jaringan** untuk mengamati perkembangan downline Anda dari Level 1 hingga kedalaman maksimal 10 tingkat.</p>
            </div>
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">
                <div class="w-7 h-7 bg-teal-700 text-white font-bold rounded-lg flex items-center justify-center text-xs">3</div>
                <h5 class="text-xs font-bold text-slate-800">Cairkan Komisi Instan</h5>
                <p class="text-xxs text-slate-500 leading-normal">Setiap bonus dari transaksi jaringan masuk ke dompet secara real-time. Anda bisa mencairkannya langsung ke rekening BSI terdaftar.</p>
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

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        // Ubah visual sementara tanda sukses
        icon.classList.replace("ph-copy", "ph-check");
        btnText.innerText = "Tersalin";
        
        // Kembalikan ke semula setelah 2 detik
        setTimeout(() => {
            icon.classList.replace("ph-check", "ph-copy");
            btnText.innerText = "Salin";
        }, 2000);
    }
</script>
@endsection