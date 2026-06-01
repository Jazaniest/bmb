@if(auth()->user() && auth()->user()->status === 'pending')
<div class="fixed inset-0 z-50 flex items-center justify-center px-4 overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-md"></div>

    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 sm:p-8 relative z-10 border border-slate-100 animate-scale-up">
        
        <div class="text-center">
            <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                <i class="ph-fill ph-lock-keyhole text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Aktivasi Kemitraan Agen</h3>
            <p class="text-sm text-slate-500 mt-2">
                Halo, <span class="font-semibold text-slate-700">{{ auth()->user()->name }}</span>. Akun Anda saat ini berstatus <span class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded-md font-medium text-xs uppercase">Pending</span>. Silakan selesaikan biaya lisensi keagenan PT. Kaukaba Tour and Travel untuk membuka akses sistem finansial penuh.
            </p>
        </div>

        <div class="mt-6 bg-slate-50 rounded-xl p-4 border border-slate-200">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Rekening Tujuan Transfer Pusat:</p>
            <div class="flex justify-between items-center mt-2">
                <div>
                    <p class="text-sm font-bold text-slate-800">Bank Syariah Indonesia (BSI)</p>
                    <p class="text-lg font-mono font-bold text-teal-700 mt-0.5">7700-1122-33</p>
                    <p class="text-xs text-slate-500 mt-0.5">Atas Nama: PT. Kaukaba Tour & Travel</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400">Nominal Wajib:</p>
                    <p class="text-base font-black text-amber-600">Rp 3.500.000</p>
                </div>
            </div>
        </div>

        <form action="{{ url('/api/payment/upload') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Unggah Foto Bukti Transfer Valid</label>
                <div class="relative flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100/50 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6 text-slate-500">
                            <i class="ph ph-cloud-arrow-up text-3xl mb-1 text-teal-600"></i>
                            <p class="text-xs font-medium">Klik untuk pilih berkas gambar (JPG, PNG max 2MB)</p>
                        </div>
                        <input type="file" name="proof_of_payment" class="hidden" required accept="image/*" />
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('logout-form-pending').submit();" class="w-1/3 h-11 border border-slate-200 text-slate-600 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors cursor-pointer">
                    Keluar
                </button>
                <button type="submit" class="w-2/3 h-11 bg-teal-700 hover:bg-teal-800 text-white rounded-xl text-sm font-semibold shadow-md transition-colors cursor-pointer">
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