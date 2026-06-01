<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-lg bg-teal-700 flex items-center justify-center text-white">
                    <i class="ph-bold ph-airplane-takeoff text-xl"></i>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-800">
                    Kaukaba <span class="text-amber-600 font-medium text-lg">Travel</span>
                </span>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? url('/admin/dashboard') : url('/agent/dashboard') }}" 
                        class="text-sm font-semibold text-teal-700 hover:text-teal-800 bg-teal-50 hover:bg-teal-100 px-4 h-10 inline-flex items-center rounded-lg transition-colors">
                        <i class="ph ph-squares-four mr-2 text-lg"></i> Dashboard
                    </a>
                @else
                    <a href="{{ url('/login') }}" 
                        class="text-sm font-medium text-slate-600 hover:text-slate-900 px-3 py-2 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ url('/register') }}" 
                        class="text-sm font-semibold text-white bg-teal-700 hover:bg-teal-800 px-4 h-10 inline-flex items-center rounded-lg shadow-xs transition-colors">
                        Daftar Agen
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>