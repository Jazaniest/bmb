<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Kaukaba')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tambahan library icons gratis jika nanti diperlukan untuk menu sidebar -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex min-h-screen overflow-x-hidden">

    @include('components.toast-alert')
    @include('components.modal-pending')

    <!-- 1. Kondisional Sidebar (Akan diisi komponen khusus sesuai Role) -->
    @if(auth()->user() && auth()->user()->role === 'admin')
        @include('components.sidebar-admin')
    @else
        @include('components.sidebar-agent')
    @endif

    <!-- 2. Area Konten Utama Dashboard -->
    <div class="flex-1 flex flex-col min-w-0 pl-0 md:pl-64">
        
        <!-- Header Atas Dashboard (Tempat Profil Singkat & Tombol Menu Mobile) -->
        <header class="bg-white h-16 border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <!-- Tombol Menu untuk Mobile (Nanti diaktifkan via JS) -->
                <button id="btn-toggle-sidebar" class="inline-block md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <i class="ph ph-list text-2xl"></i>
                </button>
                <h1 class="text-lg font-semibold text-slate-700 hidden sm:block">Panel Kaukaba</h1>
            </div>
            
            <!-- Info User Login -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-slate-800">{{ auth()->user()->name ?? 'Nama Agen' }}</p>
                    <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role ?? 'Role' }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-teal-600 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Area Isi Halaman Dashboard -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    <!-- Script sederhana untuk buka-tutup sidebar di layar HP/Mobile -->
    <script>
        document.getElementById('btn-toggle-sidebar')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar-menu');
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
            }
        });
    </script>
</body>
</html>