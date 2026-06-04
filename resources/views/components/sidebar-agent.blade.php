<aside id="sidebar-menu" class="w-64 bg-[#041916] text-slate-400 font-light fixed inset-y-0 left-0 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-teal-950/80 flex flex-col">
    <!-- Header Agen -->
    <div class="h-16 px-6 border-b border-teal-950/40 flex items-center justify-between bg-[#020F0D] shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-teal-500/10 text-teal-400 flex items-center justify-center border border-teal-500/20">
                <i class="ph ph-user-square text-lg"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-bold text-white tracking-wide uppercase leading-tight">Ruang Kerja Agen</span>
                <span class="text-xxs text-teal-400 font-medium tracking-wider mt-0.5">PT. Kaukaba Travel</span>
            </div>
        </div>
        
        <!-- Tombol Tutup Mobile -->
        <button onclick="document.getElementById('sidebar-menu').classList.add('-translate-x-full')" class="md:hidden text-slate-400 hover:text-white p-1 cursor-pointer">
            <i class="ph ph-x text-xl"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
        <a href="{{ url('/agent/dashboard') }}" class="flex items-center gap-3 px-3 h-11 rounded-xl text-xs font-medium tracking-wide transition-all duration-200 {{ Request::is('agent/dashboard') ? 'bg-white/5 text-amber-400 font-semibold border-l-2 border-amber-500 pl-2.5' : 'hover:bg-white/2 hover:text-white' }}">
            <i class="ph ph-chart-pie-slice text-lg"></i>
            <span>Overview</span>
        </a>

        <a href="{{ url('/agent/wallet') }}" class="flex items-center gap-3 px-3 h-11 rounded-xl text-xs font-medium tracking-wide transition-all duration-200 {{ Request::is('agent/wallet*') ? 'bg-white/5 text-amber-400 font-semibold border-l-2 border-amber-500 pl-2.5' : 'hover:bg-white/2 hover:text-white' }}">
            <i class="ph ph-wallet text-lg"></i>
            <span>Dompet & Komisi</span>
        </a>

        <a href="{{ url('/agent/network') }}" class="flex items-center gap-3 px-3 h-11 rounded-xl text-xs font-medium tracking-wide transition-all duration-200 {{ Request::is('agent/network*') ? 'bg-white/5 text-amber-400 font-semibold border-l-2 border-amber-500 pl-2.5' : 'hover:bg-white/2 hover:text-white' }}">
            <i class="ph ph-tree-structure text-lg"></i>
            <span>Pohon Jaringan</span>
        </a>
    </nav>

    <!-- Logout Area -->
    <div class="p-4 border-t border-teal-950/40 bg-[#020F0D] shrink-0">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 h-10 rounded-xl text-xs font-medium text-rose-400 hover:bg-rose-500/5 hover:text-rose-300 transition-all cursor-pointer">
                <i class="ph ph-sign-out text-lg"></i>
                <span>Keluar Aplikasi</span>
            </button>
        </form>
    </div>
</aside>