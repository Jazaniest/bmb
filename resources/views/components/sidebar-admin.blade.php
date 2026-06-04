<aside id="sidebar-menu" class="w-64 bg-[#091412] text-slate-400 font-light fixed inset-y-0 left-0 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-teal-950 flex flex-col">
    <!-- Header Admin -->
    <div class="h-16 px-6 border-b border-teal-950/40 flex items-center justify-between bg-[#050D0C] shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-500 flex items-center justify-center border border-amber-500/20">
                <i class="ph ph-shield-check text-lg"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-bold text-white tracking-wide uppercase leading-tight">HQ Pusat Kontrol</span>
                <span class="text-xxs text-amber-400 font-medium tracking-widest mt-0.5 uppercase">Administrator</span>
            </div>
        </div>
        
        <!-- Tombol Tutup Khusus Mobile (Pemicu JS dinamis menggunakan ID/Class Anda) -->
        <button onclick="document.getElementById('sidebar-menu').classList.add('-translate-x-full')" class="md:hidden text-slate-400 hover:text-white p-1 cursor-pointer">
            <i class="ph ph-x text-xl"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
        <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-3 h-11 rounded-xl text-xs font-medium tracking-wide transition-all duration-200 {{ Request::is('admin/dashboard') ? 'bg-white/5 text-amber-400 font-semibold border-l-2 border-amber-500 pl-2.5' : 'hover:bg-white/2 hover:text-white' }}">
            <i class="ph ph-squares-four text-lg"></i>
            <span>Dashboard Admin</span>
        </a>

        <a href="{{ url('/admin/agents/pending') }}" class="flex items-center gap-3 px-3 h-11 rounded-xl text-xs font-medium tracking-wide transition-all duration-200 {{ Request::is('admin/agents*') ? 'bg-white/5 text-amber-400 font-semibold border-l-2 border-amber-500 pl-2.5' : 'hover:bg-white/2 hover:text-white' }}">
            <i class="ph ph-check-square-offset text-lg"></i>
            <span>Verifikasi Agen</span>
        </a>

        <a href="{{ url('/admin/withdrawals') }}" class="flex items-center gap-3 px-3 h-11 rounded-xl text-xs font-medium tracking-wide transition-all duration-200 {{ Request::is('admin/withdrawals*') ? 'bg-white/5 text-amber-400 font-semibold border-l-2 border-amber-500 pl-2.5' : 'hover:bg-white/2 hover:text-white' }}">
            <i class="ph ph-hand-coins text-lg"></i>
            <span>Pencairan Dana (WD)</span>
        </a>

        <a href="{{ url('/admin/bonus-settings') }}" class="flex items-center gap-3 px-3 h-11 rounded-xl text-xs font-medium tracking-wide transition-all duration-200 {{ Request::is('admin/bonus-settings*') ? 'bg-white/5 text-amber-400 font-semibold border-l-2 border-amber-500 pl-2.5' : 'hover:bg-white/2 hover:text-white' }}">
            <i class="ph ph-sliders-horizontal text-xl"></i>
            <span>Pengaturan Bonus</span>
        </a>
    </nav>

    <!-- Logout Area -->
    <div class="p-4 border-t border-teal-950/40 bg-[#050D0C] shrink-0">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 h-10 rounded-xl text-xs font-medium text-rose-400 hover:bg-rose-500/5 hover:text-rose-300 transition-all cursor-pointer">
                <i class="ph ph-sign-out text-lg"></i>
                <span>Keluar Admin</span>
            </button>
        </form>
    </div>
</aside>