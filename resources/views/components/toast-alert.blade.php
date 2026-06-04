@if(session('success') || session('error') || $errors->any())
<div id="global-toast" class="fixed top-4 left-4 right-4 sm:top-20 sm:left-auto sm:right-4 z-50 max-w-sm bg-white rounded-xl shadow-2xl border border-slate-100 p-4 transform transition-all duration-300 translate-x-0 flex gap-3.5 items-start {{ session('success') ? 'border-l-4 border-l-emerald-500' : 'border-l-4 border-l-rose-500' }}">
    
    @if(session('success'))
        <div class="w-8 h-8 rounded-lg bg-emerald-500/5 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-500/10">
            <i class="ph ph-check-circle text-lg"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Berhasil</h4>
            <p class="text-xs text-slate-500 mt-0.5 font-light leading-relaxed">{{ session('success') }}</p>
        </div>
    @elseif(session('error') || $errors->any())
        <div class="w-8 h-8 rounded-lg bg-rose-500/5 text-rose-600 flex items-center justify-center shrink-0 border border-rose-500/10">
            <i class="ph ph-warning-circle text-lg"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Ada Masalah</h4>
            <p class="text-xs text-slate-500 mt-0.5 font-light leading-relaxed">
                {{ session('error') ?? $errors->first() }}
            </p>
        </div>
    @endif

    <button onclick="closeToast()" class="text-slate-400 hover:text-slate-600 transition-colors cursor-pointer pt-0.5">
        <i class="ph ph-x text-base"></i>
    </button>
</div>

<script>
    setTimeout(() => {
        closeToast();
    }, 4000);

    function closeToast() {
        const toast = document.getElementById('global-toast');
        if (toast) {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }
    }
</script>
@endif