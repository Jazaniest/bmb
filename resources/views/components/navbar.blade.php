<nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Brand Logo -->
            <div class="flex items-center gap-2 sm:gap-2.5 group cursor-pointer shrink-0">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-linear-to-br from-[#041E1A] to-[#0D3D35] flex items-center justify-center text-amber-400 shadow-md border border-teal-800">
                    <i class="ph ph-compass text-base sm:text-lg"></i>
                </div>
                <span class="text-base sm:text-lg font-serif font-bold tracking-tight text-slate-900">
                    Kaukaba <span class="text-transparent bg-clip-text bg-linear-to-r from-amber-600 to-amber-500 font-sans font-medium text-xs sm:text-base tracking-normal ml-0.5">Travel</span>
                </span>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-1.5 sm:gap-3">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? url('/admin/dashboard') : url('/agent/dashboard') }}" 
                        class="text-xxs sm:text-xs font-semibold text-teal-900 bg-teal-500/5 hover:bg-teal-500/10 border border-teal-500/10 px-3 sm:px-4 h-8 sm:h-9 inline-flex items-center rounded-xl transition-all tracking-wide">
                        <i class="ph ph-squares-four mr-1 sm:mr-1.5 text-sm sm:text-base"></i> Dashboard
                    </a>
                @else
                    <a href="{{ url('/login') }}" 
                        class="text-xxs sm:text-xs font-medium text-slate-600 hover:text-slate-900 px-2 sm:px-3 py-2 transition-colors tracking-wide">
                        Masuk
                    </a>
                    <a href="{{ url('/register') }}" 
                        class="text-xxs sm:text-xs font-semibold text-white bg-linear-to-r from-[#0A2E28] to-[#124E44] hover:from-teal-950 hover:to-teal-900 px-3 sm:px-4 h-8 sm:h-9 inline-flex items-center rounded-xl shadow-xs transition-all tracking-wide border border-teal-900">
                        Daftar Agen
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>