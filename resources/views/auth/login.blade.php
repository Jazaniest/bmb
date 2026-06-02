@extends('layouts.auth')

@section('title', 'Masuk Aplikasi - Kaukaba')

@section('content')
<!-- Memanggil toast alert khusus untuk memunculkan pesan error jika login gagal -->
@include('components.toast-alert')

<div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden animate-scale-up">
    <!-- Header Form Login -->
    <div class="bg-teal-800 text-white p-6 text-center relative">
        <a href="{{ url('/') }}" class="absolute top-6 left-6 text-teal-200 hover:text-white transition-colors">
            <i class="ph ph-arrow-left text-xl"></i>
        </a>
        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mx-auto mb-2 border border-white/10">
            <i class="ph-bold ph-airplane-takeoff text-2xl text-amber-400"></i>
        </div>
        <h2 class="text-xl font-bold">Selamat Datang Kembali</h2>
        <p class="text-xs text-teal-200 mt-1">Masuk ke Panel Kaukaba Tour & Travel</p>
    </div>

    <!-- Area Isi Form -->
    <form action="{{ url('/login') }}" method="POST" class="p-6 space-y-4">
        @csrf

        <!-- Input Email -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="ph ph-envelope text-lg"></i>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-hidden focus:border-teal-600 focus:bg-white transition-colors"
                    placeholder="nama@email.com">
            </div>
        </div>

        <!-- Input Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Password</label>
                <a href="#" class="text-xxs font-bold text-teal-700 hover:underline">Lupa Password?</a>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="ph ph-lock text-lg"></i>
                </div>
                <input type="password" name="password" id="password-input" required
                    class="w-full h-11 pl-10 pr-10 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-hidden focus:border-teal-600 focus:bg-white transition-colors"
                    placeholder="••••••••">
                <!-- Tombol Intip Password (Eye Icon) -->
                <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i id="password-toggle-icon" class="ph ph-eye text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Opsi Ingat Saya (Remember Me) -->
        <div class="flex items-center gap-2 pt-1">
            <input type="checkbox" name="remember" id="remember" class="accent-teal-700 rounded-sm cursor-pointer">
            <label for="remember" class="text-xs text-slate-500 user-select-none cursor-pointer">
                Ingat sesi masuk saya di perangkat ini
            </label>
        </div>

        <!-- Tombol Submit Masuk -->
        <button type="submit" class="w-full h-11 bg-teal-700 hover:bg-teal-800 text-white font-bold rounded-xl text-sm shadow-md transition-colors cursor-pointer pt-0.5 flex items-center justify-center gap-2">
            <i class="ph ph-sign-in text-lg"></i> Masuk Aplikasi
        </button>

        <!-- Jalur Alternatif ke Register -->
        <div class="text-center pt-2 border-t border-slate-100 mt-4">
            <p class="text-xs text-slate-500">
                Tertarik bergabung kemitraan? <a href="{{ url('/register') }}" class="text-teal-700 font-bold hover:underline">Daftar Akun Baru</a>
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

<!-- @if (session('error'))
    <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg dark:bg-gray-800 dark:text-red-400" role="alert">
        <span class="font-medium">Perhatian!</span> {{ session('error') }}
    </div>
@endif -->