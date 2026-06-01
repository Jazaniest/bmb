@extends('layouts.auth')

@section('title', 'Pendaftaran Agen Baru - Kaukaba')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
    <!-- Header Form -->
    <div class="bg-teal-800 text-white p-6 text-center relative">
        <a href="{{ url('/') }}" class="absolute top-6 left-6 text-teal-200 hover:text-white transition-colors">
            <i class="ph ph-arrow-left text-xl"></i>
        </a>
        <h2 class="text-xl font-bold">Gabung Kemitraan</h2>
        <p class="text-xs text-teal-200 mt-1">Isi data diri Anda untuk mulai membangun jaringan syiar</p>
    </div>

    <!-- Area Isi Form -->
    <form action="{{ url('/register') }}" method="POST" class="p-6 space-y-4">
        @csrf

        <!-- 1. KOLOM REFERRAL SPONSOR (AUTO-LOCK) -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Kode Referral Sponsor</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="ph-bold ph-users-three text-lg"></i>
                </div>
                <input type="text" name="sponsor_code" value="{{ old('sponsor_code', $referralCode ?? '') }}" 
                    class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-300 rounded-xl text-sm font-semibold text-slate-800 focus:outline-hidden focus:border-teal-600 focus:bg-white transition-colors {{ !empty($referralCode) ? 'bg-teal-50/50 border-teal-200 text-teal-900 font-mono' : '' }}"
                    placeholder="Masukkan kode sponsor (Opsional)" 
                    {{ !empty($referralCode) ? 'readonly' : '' }}>
            </div>
            @if(!empty($referralCode))
                <p class="text-xxs text-teal-600 mt-1 font-medium flex items-center gap-1">
                    <i class="ph-fill ph-check-circle"></i> Sponsor Anda terkunci otomatis melalui link referral.
                </p>
            @else
                <p class="text-xxs text-slate-400 mt-1">Kosongkan jika Anda mendaftar tanpa sponsor langsung.</p>
            @endif
        </div>

        <hr class="border-slate-100 my-2">

        <!-- 2. DATA DIRI AGEN -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="ph ph-user text-lg"></i>
                </div>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-hidden focus:border-teal-600 focus:bg-white transition-colors"
                    placeholder="Nama sesuai KTP">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="ph ph-envelope text-lg"></i>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-hidden focus:border-teal-600 focus:bg-white transition-colors"
                    placeholder="nama@email.com">
            </div>
        </div>

        <!-- 3. KREDENSIAL PASSWORD -->
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-hidden focus:border-teal-600 focus:bg-white transition-colors"
                    placeholder="Minimal 8 karakter">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Konfirmasi</label>
                <input type="password" name="password_confirmation" required
                    class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-hidden focus:border-teal-600 focus:bg-white transition-colors"
                    placeholder="Ulangi password">
            </div>
        </div>

        <!-- 4. INFORMASI BANK UNTUK PENCAIRAN BONUS -->
        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 space-y-3">
            <p class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Rekening Bank Pencairan Komisi</p>
            
            <div class="grid grid-cols-2 gap-2">
                <input type="text" name="bank_name" value="{{ old('bank_name') }}" required
                    class="w-full h-10 px-3 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-hidden focus:border-teal-600"
                    placeholder="Nama Bank (Misal: BSI)">
                
                <input type="text" name="account_number" value="{{ old('account_number') }}" required
                    class="w-full h-10 px-3 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-hidden focus:border-teal-600"
                    placeholder="Nomor Rekening">
            </div>

            <input type="text" name="account_name" value="{{ old('account_name') }}" required
                class="w-full h-10 px-3 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-hidden focus:border-teal-600"
                placeholder="Nama Pemilik Rekening (Sesuai Buku Tabungan)">
        </div>

        <!-- Syarat & Ketentuan Lisensi -->
        <div class="flex items-start gap-2 pt-1">
            <input type="checkbox" id="terms" required class="mt-1 accent-teal-700 cursor-pointer">
            <label for="terms" class="text-xxs text-slate-500 leading-normal cursor-pointer">
                Saya menyetujui biaya aktivasi lisensi keagenan PT. Kaukaba sebesar **Rp 3.500.000** setelah pendaftaran ini berhasil dilakukan.
            </label>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="w-full h-11 bg-teal-700 hover:bg-teal-800 text-white font-bold rounded-xl text-sm shadow-md transition-colors cursor-pointer pt-0.5">
            Daftar Sebagai Agen Resmi
        </button>

        <!-- Link ke Halaman Login -->
        <div class="text-center pt-2">
            <p class="text-xs text-slate-500">
                Sudah memiliki akun? <a href="{{ url('/login') }}" class="text-teal-700 font-bold hover:underline">Masuk di sini</a>
            </p>
        </div>
    </form>
</div>