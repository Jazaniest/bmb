@extends('layouts.auth')

@section('title', 'Pendaftaran Agen Baru - Kaukaba')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-slate-200/80 overflow-hidden transform transition-all duration-300">
    <!-- Header Form -->
    <div class="bg-linear-to-br from-[#041E1A] to-[#0A2E28] text-white p-6 text-center relative overflow-hidden">
        <div class="absolute -right-6 -top-6 opacity-[0.05] text-white pointer-events-none select-none">
            <i class="ph ph-hand-heart text-7xl"></i>
        </div>

        <a href="{{ url('/') }}" class="absolute top-6 left-6 text-teal-300 hover:text-white transition-colors group" aria-label="Kembali">
            <i class="ph ph-arrow-left text-xl transform group-hover:-translate-x-0.5 transition-transform"></i>
        </a>
        <h2 class="text-xl font-serif font-bold tracking-wide">Gabung Kemitraan</h2>
        <p class="text-xs text-teal-200/80 mt-1 font-light">Isi data diri Anda untuk mulai membangun jaringan syiar</p>
    </div>

    <!-- Area Isi Form -->
    <form action="{{ url('/register') }}" method="POST" class="p-6 space-y-4">
        @csrf

        <!-- 1. KOLOM REFERRAL SPONSOR (AUTO-LOCK) -->
        <div class="space-y-1">
            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Kode Referral Sponsor</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="ph-bold ph-users-three text-lg"></i>
                </div>
                <input type="text" name="sponsor_code" value="{{ old('sponsor_code', $referralCode ?? '') }}" 
                    class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-hidden focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 focus:bg-white transition-all {{ !empty($referralCode) ? 'bg-teal-50/60 border-teal-200 text-teal-950 font-mono tracking-wider' : '' }}"
                    placeholder="Masukkan kode sponsor (Opsional)" 
                    {{ !empty($referralCode) ? 'readonly' : '' }}>
            </div>
            @if(!empty($referralCode))
                <p class="text-[10px] text-teal-600 mt-1 font-medium flex items-center gap-1">
                    <i class="ph-fill ph-check-circle text-xs shrink-0"></i> Sponsor Anda terkunci otomatis via tautan.
                </p>
            @else
                <p class="text-[10px] text-slate-400 font-light mt-1">Kosongkan jika Anda mendaftar tanpa sponsor langsung.</p>
            @endif
        </div>

        <hr class="border-slate-100 my-1">

        <!-- 2. DATA DIRI AGEN -->
        <div class="space-y-1">
            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="ph ph-user text-lg"></i>
                </div>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 focus:bg-white transition-all"
                    placeholder="Nama sesuai KTP">
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="ph ph-envelope text-lg"></i>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 focus:bg-white transition-all"
                    placeholder="nama@email.com">
            </div>
        </div>

        <!-- 3. KREDENSIAL PASSWORD (RESPONSIF GRID) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Password</label>
                <input type="password" name="password" required
                    class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 focus:bg-white transition-all"
                    placeholder="Min. 8 karakter">
            </div>
            <div class="space-y-1">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Konfirmasi</label>
                <input type="password" name="password_confirmation" required
                    class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 focus:bg-white transition-all"
                    placeholder="Ulangi password">
            </div>
        </div>

        <!-- 4. INFORMASI BANK UNTUK PENCAIRAN BONUS (RESPONSIF GRID) -->
        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/70 space-y-3">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                <i class="ph ph-bank text-sm"></i> Rekening Bank Pencairan Komisi
            </p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <input type="text" name="bank_name" value="{{ old('bank_name') }}" required
                    class="w-full h-10 px-3 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:border-teal-600 focus:ring-2 focus:ring-teal-600/5"
                    placeholder="Nama Bank (Misal: BSI)">
                
                <input type="text" name="account_number" value="{{ old('account_number') }}" required
                    class="w-full h-10 px-3 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:border-teal-600 focus:ring-2 focus:ring-teal-600/5"
                    placeholder="Nomor Rekening">
            </div>

            <input type="text" name="account_name" value="{{ old('account_name') }}" required
                class="w-full h-10 px-3 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:border-teal-600 focus:ring-2 focus:ring-teal-600/5"
                placeholder="Nama Pemilik Rekening (Sesuai Tabungan)">
        </div>

        <!-- Syarat & Ketentuan Lisensi -->
        <div class="flex items-start gap-2.5 pt-1">
            <input type="checkbox" id="terms" required class="w-4 h-4 mt-0.5 accent-teal-700 rounded border-slate-300 cursor-pointer shrink-0">
            <label for="terms" class="text-[11px] text-slate-500 leading-normal cursor-pointer select-none">
                Saya menyetujui biaya aktivasi lisensi keagenan PT. Kaukaba sebesar <strong class="text-slate-800 font-bold">Rp 3.500.000</strong> setelah pendaftaran ini berhasil dilakukan.
            </label>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="w-full h-11 bg-linear-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-950 text-white font-bold rounded-xl text-sm shadow-md shadow-teal-950/10 transition-all transform active:scale-[0.98] cursor-pointer tracking-wide mt-2">
            Daftar Sebagai Agen Resmi
        </button>

        <!-- Link ke Halaman Login -->
        <div class="text-center pt-2">
            <p class="text-xs text-slate-500 font-light">
                Sudah memiliki akun? <a href="{{ url('/login') }}" class="text-teal-700 font-bold hover:text-teal-800 hover:underline transition-colors ml-0.5">Masuk di sini</a>
            </p>
        </div>
    </form>
</div>
@endsection