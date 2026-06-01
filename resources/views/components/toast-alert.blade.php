@if(session('success') || session('error') || $errors->any())
<div id="global-toast" class="fixed top-20 right-4 z-50 max-w-sm w-full bg-white rounded-xl shadow-xl border border-slate-100 p-4 transform transition-all duration-300 translate-x-0 flex gap-3 items-start animate-bounce-short">
    
    @if(session('success'))
        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <i class="ph-bold ph-check-circle text-xl"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-semibold text-slate-800">Berhasil</h4>
            <p class="text-xs text-slate-600 mt-0.5">{{ session('success') }}</p>
        </div>
    @elseif(session('error') || $errors->any())
        <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
            <i class="ph-bold ph-warning-circle text-xl"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-semibold text-slate-800">Ada Masalah</h4>
            <p class="text-xs text-slate-600 mt-0.5">
                {{ session('error') ?? $errors->first() }}
            </p>
        </div>
    @endif

    <button onclick="closeToast()" class="text-slate-400 hover:text-slate-600 cursor-pointer">
        <i class="ph ph-x text-lg"></i>
    </button>
</div>

<script>
    // Fungsi menghilangkan toast otomatis dalam 4 detik
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