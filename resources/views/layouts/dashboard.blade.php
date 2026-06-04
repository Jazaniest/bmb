<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard - Kaukaba')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex min-h-screen overflow-x-hidden selection:bg-teal-800 selection:text-white">

    @include('components.toast-alert')
    @include('components.modal-pending')

    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-950/40 backdrop-blur-xs z-30 hidden transition-opacity duration-300 opacity-0 md:hidden"></div>

    @if(auth()->user() && auth()->user()->role === 'admin')
        @include('components.sidebar-admin')
    @else
        @include('components.sidebar-agent')
    @endif

    <div class="flex-1 flex flex-col min-w-0 pl-0 md:pl-64 transition-all duration-300">
        
        <header class="bg-white h-16 border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-20 shadow-xs">
            
            <div class="flex items-center gap-3">
                <button id="btn-toggle-sidebar" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer" aria-label="Buka Menu">
                    <i class="ph ph-list text-2xl"></i>
                </button>
                <h1 class="text-base sm:text-lg font-semibold text-slate-700 tracking-tight hidden sm:block">Panel Kaukaba</h1>
            </div>
            
            <div class="flex items-center gap-3 shrink-0">
                <div class="text-right hidden sm:block">
                    <p class="text-xs sm:text-sm font-semibold text-slate-800 truncate max-w-35">{{ auth()->user()->name ?? 'Nama User' }}</p>
                    <p class="text-[10px] sm:text-xs text-amber-600 font-medium capitalize tracking-wider mt-0.5">{{ auth()->user()->role ?? 'Role' }}</p>
                </div>
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-linear-to-br from-[#041E1A] to-[#124E44] border border-teal-900/30 flex items-center justify-center text-amber-400 font-bold shadow-xs text-sm sm:text-base tracking-wide select-none">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 max-w-7xl w-full mx-auto animate-fade-in">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnToggle = document.getElementById('btn-toggle-sidebar');
            const sidebar = document.getElementById('sidebar-menu');
            const overlay = document.getElementById('sidebar-overlay');

            // Fungsi Global Buka Sidebar
            function openSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    setTimeout(() => overlay.classList.add('opacity-100'), 10);
                }
            }

            // Fungsi Global Tutup Sidebar
            function closeSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.remove('opacity-100');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                }
            }

            // Pemicu Klik Elemen
            btnToggle?.addEventListener('click', openSidebar);
            overlay?.addEventListener('click', closeSidebar);

            // Mendaftarkan fungsi tutup ke window agar tombol Close (ph-x) internal di file sidebar Anda ikut berfungsi sinkron
            window.closeMobileSidebar = closeSidebar;
            
            // Integrasi ulang tombol silang internal bawaan sidebar agar memicu fungsi penutupan berset-overlay
            const internalCloseBtn = sidebar?.querySelector('button[onclick*="translate-x-full"]');
            if (internalCloseBtn) {
                internalCloseBtn.removeAttribute('onclick');
                internalCloseBtn.addEventListener('click', closeSidebar);
            }
        });
    </script>
</body>
</html>