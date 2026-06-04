@extends('layouts.dashboard')

@section('title', 'Pengaturan Komisi Unilevel - Manajemen Pusat')

@section('content')
@include('components.toast-alert')

<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">Pengaturan Skema Bonus Berjenjang</h2>
                <p class="text-xs text-slate-500 mt-0.5">Sesuaikan nominal komisi rupiah masing-masing tingkat sponsor saat aktivasi agen baru.</p>
            </div>
        </div>
        <div class="bg-teal-50 border border-teal-200 text-teal-800 text-xxs font-bold px-3 py-2 rounded-xl flex items-center gap-1.5 shrink-0 self-start sm:self-center shadow-xxs">
            <i class="ph ph-layers-bold text-sm"></i>
            Maksimal 10 Tingkat
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        
        {{-- Session Flash Alert --}}
        @if(session('success'))
            <div class="m-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl flex items-center gap-2.5">
                <i class="ph ph-check-circle text-lg"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="m-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold rounded-xl flex items-center gap-2.5">
                <i class="ph ph-warning-circle text-lg"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <form action="{{ url('/admin/bonus-settings/update') }}" method="POST">
            @csrf
            
            <div class="divide-y divide-slate-100 px-6">
                @foreach($bonusSettings as $setting)
                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 hover:bg-slate-50/30 transition-colors -mx-6 px-6">
                    <div class="sm:w-1/3">
                        <label class="block text-xs font-bold text-slate-700 tracking-tight">
                            @if($setting->level === 1)
                                <span class="text-teal-600 bg-teal-50 border border-teal-100/70 px-3 py-1.5 rounded-xl flex items-center gap-1.5 w-fit">
                                    <i class="ph ph-user-focus text-base"></i> Level 1 (Sponsor Langsung)
                                </span>
                            @else
                                <span class="text-slate-600 bg-slate-50 border border-slate-200/60 px-3 py-1.5 rounded-xl flex items-center gap-1.5 w-fit ml-1">
                                    <i class="ph ph-git-commit text-sm text-slate-400"></i> Level {{ $setting->level }} (Generasi Dalam)
                                </span>
                            @endif
                        </label>
                    </div>
                    
                    <div class="sm:w-2/3 relative rounded-xl shadow-xxs max-w-md w-full">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <span class="text-slate-400 font-bold text-xs font-mono">Rp</span>
                        </div>
                        <input 
                            type="number" 
                            name="amounts[{{ $setting->level }}]" 
                            value="{{ (int) $setting->amount }}" 
                            min="0"
                            class="block w-full rounded-xl border border-slate-200 pl-11 pr-4 py-2.5 text-xs font-bold text-slate-700 bg-slate-50/40 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-50 transition-all outline-none"
                            placeholder="0"
                            required
                        >
                    </div>
                </div>
                @endforeach
            </div>

            <div class="bg-slate-50 border-t border-slate-200/60 px-6 py-4 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 h-10 px-5 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xxs rounded-xl transition-all duration-200 cursor-pointer shadow-md hover:shadow-lg">
                    <i class="ph ph-floppy-disk text-base"></i> Simpan Perubahan Skema
                </button>
            </div>
        </form>
    </div>
</div>
@endsection