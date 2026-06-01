<aside id="sidebar-menu" class="w-64 bg-slate-950 text-slate-300 fixed inset-y-0 left-0 z-30 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-800 flex flex-col">
    <div class="h-16 px-6 border-b border-slate-800 flex items-center gap-2 bg-slate-900/50">
        <div class="w-8 h-8 rounded-md bg-teal-600 flex items-center justify-center text-white">
            <i class="ph-bold ph-user-square text-lg"></i>
        </div>
        <div class="flex flex-col">
            <span class="text-sm font-bold text-white leading-tight">Ruang Kerja Agen</span>
            <span class="text-xs text-teal-400 font-medium">PT. Kaukaba</span>
        </div>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        <a href="{{ url('/agent/dashboard') }}" class="flex items-center gap-3 px-3 h-11 rounded-lg text-sm font-medium transition-colors {{ Request::is('agent/dashboard') ? 'bg-teal-700 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white' }}">
            <i class="ph ph-chart-pie-slice text-xl"></i>
            <span>Overview</span>
        </a>

        <a href="{{ url('/agent/wallet') }}" class="flex items-center gap-3 px-3 h-11 rounded-lg text-sm font-medium transition-colors {{ Request::is('agent/wallet*') ? 'bg-teal-700 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white' }}">
            <i class="ph ph-wallet text-xl"></i>
            <span>Dompet & Komisi</span>
        </a>

        <a href="{{ url('/agent/network') }}" class="flex items-center gap-3 px-3 h-11 rounded-lg text-sm font-medium transition-colors {{ Request::is('agent/network*') ? 'bg-teal-700 text-white font-semibold' : 'hover:bg-slate-900 hover:text-white' }}">
            <i class="ph ph-tree-structure text-xl"></i>
            <span>Pohon Jaringan</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-800">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 h-11 rounded-lg text-sm font-medium text-rose-400 hover:bg-rose-950/30 hover:text-rose-300 transition-colors cursor-pointer">
                <i class="ph ph-sign-out text-xl"></i>
                <span>Keluar Aplikasi</span>
            </button>
        </form>
    </div>
</aside>