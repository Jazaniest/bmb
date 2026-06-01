<aside id="sidebar-menu" class="w-64 bg-slate-900 text-slate-300 fixed inset-y-0 left-0 z-30 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-800 flex flex-col">
    <div class="h-16 px-6 border-b border-slate-800 flex items-center gap-2 bg-slate-950">
        <div class="w-8 h-8 rounded-md bg-amber-600 flex items-center justify-center text-white">
            <i class="ph-bold ph-shield-check text-lg"></i>
        </div>
        <div class="flex flex-col">
            <span class="text-sm font-bold text-white leading-tight">HQ Pusat Kontrol</span>
            <span class="text-xs text-amber-500 font-medium">Administrator</span>
        </div>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-3 h-11 rounded-lg text-sm font-medium transition-colors {{ Request::is('admin/dashboard') ? 'bg-amber-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
            <i class="ph ph-squares-four text-xl"></i>
            <span>Dashboard Admin</span>
        </a>

        <a href="{{ url('/admin/payments') }}" class="flex items-center gap-3 px-3 h-11 rounded-lg text-sm font-medium transition-colors {{ Request::is('admin/payments*') ? 'bg-amber-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
            <i class="ph ph-check-square-offset text-xl"></i>
            <span>Verifikasi Agen</span>
        </a>

        <a href="{{ url('/admin/withdrawals') }}" class="flex items-center gap-3 px-3 h-11 rounded-lg text-sm font-medium transition-colors {{ Request::is('admin/withdrawals*') ? 'bg-amber-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
            <i class="ph ph-hand-coins text-xl"></i>
            <span>Pencairan Dana (WD)</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-800">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 h-11 rounded-lg text-sm font-medium text-rose-400 hover:bg-rose-950/30 hover:text-rose-300 transition-colors cursor-pointer">
                <i class="ph ph-sign-out text-xl"></i>
                <span>Keluar Admin</span>
            </button>
        </form>
    </div>
</aside>