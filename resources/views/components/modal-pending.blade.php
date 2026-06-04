@if(auth()->user() && auth()->user()->status === 'pending')
<div class="fixed inset-0 z-50 flex items-center justify-center px-4 overflow-y-auto py-6">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-md"></div>

    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-5 sm:p-8 relative z-10 border border-slate-100 my-auto">
        
        <div class="text-center">
            <div class="w-14 h-14 bg-amber-500/5 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-amber-500/10">
                <i class="ph ph-lock-keyhole text-2xl"></i>
            </div>
            <h3 class="text-xl font-serif font-bold text-slate-900 tracking-tight">Aktivasi Kemitraan Agen</h3>
            <p class="text-sm text-slate-500 mt-2 font-light leading-relaxed">
                Halo, <span class="font-semibold text-slate-800">{{ auth()->user()->name }}</span>. Status kemitraan Anda saat ini adalah <span class="inline-block px-2 py-0.5 bg-amber-500/10 text-amber-600 rounded-md font-medium text-xs uppercase tracking-wider border border-amber-500/10">Pending</span>. Silakan selesaikan biaya lisensi keagenan untuk membuka akses penuh.
            </p>
        </div>

        <div class="mt-6 bg-linear-to-br from-slate-50 to-white rounded-2xl p-4 sm:p-5 border border-amber-500/20 shadow-xs relative overflow-hidden">
            <p class="text-xxs font-bold uppercase tracking-widest text-slate-400 mb-3">Rekening Tujuan Transfer Pusat:</p>
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-baseline gap-4">
                <div>
                    <p class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-600"></span> Bank Syariah Indonesia (BSI)
                    </p>
                    <p class="text-lg sm:text-xl font-mono font-bold text-teal-950 tracking-wider mt-1">7700-1122-33</p>
                    <p class="text-xs text-slate-400 mt-0.5 font-light">Atas Nama: PT. Kaukaba Tour & Travel</p>
                </div>
                <div class="sm:text-right pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-150 flex sm:flex-col justify-between items-center sm:items-end">
                    <p class="text-xxs text-slate-400 uppercase tracking-wider">Nominal Wajib:</p>
                    <p class="text-base sm:text-lg font-bold text-amber-600">Rp 3.500.000</p>
                </div>
            </div>
        </div>

        <form action="{{ url('/api/payment/upload') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xxs font-bold text-slate-500 uppercase tracking-widest mb-2">Unggah Foto Bukti Transfer Valid</label>
                <div class="relative flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-28 border border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50/50 hover:bg-slate-50 transition-all group">
                        <div class="text-center px-4 text-slate-400">
                            <i class="ph ph-cloud-arrow-up text-xl mb-1 text-slate-400 group-hover:text-amber-500 transition-colors"></i>
                            <p class="text-xs font-light">Klik untuk pilih gambar bukti transfer</p>
                            <p class="text-xxs text-slate-400 mt-0.5 font-light">(JPG, PNG max 2MB)</p>
                        </div>
                        <input type="file" name="proof_of_payment" class="hidden" required accept="image/*" />
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-1">
                <button type="button" onclick="document.getElementById('logout-form-pending').submit();" class="w-1/3 h-11 border border-slate-200 text-slate-600 rounded-xl text-xs sm:text-sm font-medium hover:bg-slate-50 transition-colors cursor-pointer">
                    Keluar
                </button>
                <button type="submit" class="w-2/3 h-11 bg-linear-to-r from-[#0A2E28] to-[#124E44] text-white rounded-xl text-xs sm:text-sm font-semibold shadow-md transition-colors cursor-pointer">
                    Kirim Bukti Pembayaran
                </button>
            </div>
        </form>

        <form id="logout-form-pending" action="{{ url('/logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>
@endif