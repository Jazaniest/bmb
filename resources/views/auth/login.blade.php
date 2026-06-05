@extends('layouts.auth')

@section('title', 'Masuk Aplikasi - BMB')

@section('content')
<!-- Memanggil toast alert khusus untuk memunculkan pesan error jika login gagal -->
@include('components.toast-alert')

<div class="bg-white rounded-2xl shadow-xl border border-slate-200/80 overflow-hidden transform transition-all duration-300">
    <!-- Header Form Login (Premium Dark Emerald Gradient) -->
    <div class="bg-linear-to-br from-[#041E1A] to-[#0A2E28] text-white p-6 sm:p-8 text-center relative overflow-hidden">
        <!-- Dekorasi Ornamen Tipis -->
        <div class="absolute -right-6 -top-6 opacity-[0.05] text-white pointer-events-none select-none">
            <i class="ph ph-mosque text-7xl"></i>
        </div>
        
        <a href="{{ url('/') }}" class="absolute top-6 left-6 text-teal-300 hover:text-white transition-colors group" aria-label="Kembali">
            <i class="ph ph-arrow-left text-xl transform group-hover:-translate-x-0.5 transition-transform"></i>
        </a>
        
        <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center mx-auto mb-3 border border-white/10 shadow-inner">
            <i class="ph-bold ph-airplane-takeoff text-xl text-amber-400 animate-pulse"></i>
        </div>
        <h2 class="text-xl font-serif font-bold tracking-wide">Selamat Datang Kembali</h2>
        <p class="text-xs text-teal-200/80 mt-1 font-light">Masuk ke Panel BMB Tour & Travel</p>
    </div>

    <!-- Area Isi Form -->
    <form action="{{ url('/login') }}" method="POST" class="p-6 space-y-4">
        @csrf

        <!-- Input Email -->
        <div class="space-y-1">
            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="ph ph-envelope text-lg"></i>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 focus:bg-white transition-all"
                    placeholder="nama@email.com">
            </div>
        </div>

        <!-- Input Password -->
        <div class="space-y-1">
            <div class="flex justify-between items-center">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Password</label>
                <a href="#" class="text-[11px] font-bold text-teal-700 hover:text-teal-800 hover:underline transition-colors">Lupa Password?</a>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="ph ph-lock text-lg"></i>
                </div>
                <input type="password" name="password" id="password-input" required
                    class="w-full h-11 pl-10 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 focus:bg-white transition-all"
                    placeholder="••••••••">
                <!-- Tombol Intip Password -->
                <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer transition-colors" tabindex="-1">
                    <i id="password-toggle-icon" class="ph ph-eye text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Opsi Ingat Saya (Remember Me) -->
        <div class="flex items-start gap-2.5 pt-1">
            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 mt-0.5 accent-teal-700 rounded border-slate-300 cursor-pointer">
            <label for="remember" class="text-xs text-slate-500 select-none cursor-pointer leading-tight">
                Ingat sesi masuk saya di perangkat ini
            </label>
        </div>

        <!-- Tombol Submit Masuk -->
        <button type="submit" class="w-full h-11 bg-linear-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-950 text-white font-bold rounded-xl text-sm shadow-md shadow-teal-950/10 transition-all transform active:scale-[0.98] cursor-pointer flex items-center justify-center gap-2 tracking-wide mt-2">
            <i class="ph ph-sign-in text-lg"></i> Masuk Aplikasi
        </button>

        <!-- Jalur Alternatif ke Register -->
        <div class="text-center pt-4 border-t border-slate-100 mt-5">
            <p class="text-xs text-slate-500 font-light">
                Tertarik bergabung kemitraan? <a href="{{ url('/register') }}" class="text-teal-700 font-bold hover:text-teal-800 hover:underline transition-colors ml-0.5">Daftar Akun Baru</a>
            </p>
        </div>
    </form>
</div>

<!-- Script Sederhana untuk Fitur Intip Password -->
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password-input');
        const toggleIcon = document.getElementById('password-toggle-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.replace('ph-eye', 'ph-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.replace('ph-eye-slash', 'ph-eye');
        }
    }
</script>
@endsection