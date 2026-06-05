@extends('layouts.app')

@section('title', 'PT. BMB Tour & Travel - Solusi Umrah & Haji Premium')

@section('content')

<!-- ================= 1. HERO SECTION ================= -->
<section class="relative bg-linear-to-b from-[#041E1A] to-[#0A2E28] text-white py-16 sm:py-24 lg:py-36 overflow-hidden">
    <!-- Ornamen Estetik Latar Belakang -->
    <div class="absolute inset-0 opacity-[0.02] flex items-center justify-center pointer-events-none select-none">
        <i class="ph ph-mosque text-[300px] sm:text-[600px]"></i>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <!-- Teks Ajakan Utama -->
            <div class="space-y-6 sm:space-y-7 text-center lg:text-left">
                <span class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 rounded-full text-[10px] sm:text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 uppercase tracking-widest">
                    <i class="ph-fill ph-circle-wavy-check text-xs sm:text-sm"></i> Biro Perjalanan Umrah Resmi & Terpercaya
                </span>
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-serif font-bold tracking-tight leading-[1.2] lg:leading-[1.15]">
                    Melangkah Pasti <br class="hidden sm:inline">Menuju <span class="text-transparent bg-clip-text bg-linear-to-r from-amber-300 via-amber-400 to-amber-200 drop-shadow-xs">Baitullah</span>
                </h1>
                <p class="text-sm sm:text-lg text-teal-100/80 max-w-xl mx-auto lg:mx-0 leading-relaxed font-light">
                    Wujudkan ibadah Umrah dan Haji yang mabrur dengan fasilitas premium, bimbingan sesuai Sunnah, dan kepastian jadwal keberangkatan bersama PT. BMB Tour & Travel.
                </p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-3.5 pt-2">
                    <a href="#paket" class="h-12 sm:h-14 px-6 sm:px-8 bg-linear-to-r from-amber-500 to-amber-400 hover:from-amber-600 hover:to-amber-500 text-slate-950 font-bold rounded-xl inline-flex items-center justify-center shadow-lg shadow-amber-950/20 transition-all transform hover:-translate-y-0.5 cursor-pointer tracking-wide text-sm">
                        Lihat Paket Premium
                    </a>
                    <a href="{{ url('/register') }}" class="h-12 sm:h-14 px-6 sm:px-8 bg-white/5 hover:bg-white/10 text-white font-medium rounded-xl inline-flex items-center justify-center border border-white/10 backdrop-blur-xs transition-all cursor-pointer text-sm">
                        Gabung Kemitraan Agen
                    </a>
                </div>
            </div>

            <!-- Visual Kanan (Aktif dari Tablet Hingga Desktop dengan Layout Fleksibel) -->
            <div class="hidden md:flex lg:flex justify-center relative h-105 mt-8 lg:mt-0">
                <!-- Kartu Belakang -->
                <div class="w-64 sm:w-72 h-80 sm:h-96 bg-slate-900 rounded-3xl border border-white/10 shadow-2xl overflow-hidden absolute left-4 sm:left-12 top-4 transform -rotate-6 transition-all duration-500 hover:rotate-0 hover:z-20 group">
                    <img src="https://images.unsplash.com/photo-1565552645632-d725f8bfc19a?auto=format&fit=crop&w=600&q=80" alt="Umrah Madinah" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/40 to-transparent p-5 sm:p-7 flex flex-col justify-end">
                        <span class="text-amber-400 text-[10px] font-semibold uppercase tracking-wider bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded-md w-max">Paket Regular</span>
                        <h4 class="text-lg sm:text-xl font-serif font-bold text-white mt-2">Umrah Syawal 9 Hari</h4>
                        <p class="text-xs text-slate-300 mt-1 font-light flex items-center gap-1.5">
                            <i class="ph ph-star text-amber-400"></i> Hotel Bintang 5 | Pesawat Direct
                        </p>
                    </div>
                </div>
                
                <!-- Kartu Depan -->
                <div class="w-64 sm:w-72 h-80 sm:h-96 bg-slate-900 rounded-3xl border border-amber-500/20 shadow-2xl overflow-hidden absolute left-36 sm:left-48 top-12 p-0 flex flex-col justify-end transform rotate-6 transition-all duration-500 hover:rotate-0 hover:z-20 group">
                    <img src="https://images.unsplash.com/photo-1591604121669-f2832ac29c97?auto=format&fit=crop&w=600&q=80" alt="Umrah VIP Makkah" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/40 to-transparent p-5 sm:p-7 flex flex-col justify-end">
                        <span class="text-amber-400 text-[10px] font-semibold uppercase tracking-wider bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded-md w-max">Paket VIP Luxury</span>
                        <h4 class="text-lg sm:text-xl font-serif font-bold text-white mt-2">Premium Akhir Tahun</h4>
                        <p class="text-xs text-slate-300 mt-1 font-light flex items-center gap-1.5">
                            <i class="ph ph-crown text-amber-400"></i> Makkah Tower | Bus Eksklusif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave/Divider Halus -->
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-linear-to-t from-white to-transparent opacity-100"></div>
</section>

<!-- ================= 2. PAKET UNGGULAN SECTION ================= -->
<section id="paket" class="py-16 sm:py-24 bg-[#FAFAFA]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-12 sm:mb-20">
            <span class="text-xs font-bold text-teal-800 uppercase tracking-widest bg-teal-50 px-3 py-1 rounded-md">Program Unggulan</span>
            <h2 class="text-2xl sm:text-4xl font-serif font-bold text-slate-900 tracking-tight">Pilihan Paket Perjalanan Terbaik</h2>
            <div class="w-12 h-0.5 bg-amber-500 mx-auto my-2"></div>
            <p class="text-slate-500 max-w-xl mx-auto text-xs sm:text-base font-light">
                Pilihlah jadwal dan akomodasi yang sesuai dengan kenyamanan ibadah Anda dan keluarga.
            </p>
        </div>

        <!-- Grid Kartu Paket Modern -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 items-stretch">
            
            <!-- Kartu 1: Paket Hemat -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden flex flex-col hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="h-44 sm:h-48 relative overflow-hidden bg-slate-950">
                    <img src="https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&w=500&q=80" alt="Paket Hemat" class="w-full h-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/20 to-transparent p-5 sm:p-6 flex flex-col justify-end">
                        <h3 class="text-base sm:text-lg font-serif font-bold text-white">Umrah Hemat Berkah</h3>
                        <p class="text-xxs sm:text-xs text-amber-400 mt-0.5">Keberangkatan: Agustus 2026</p>
                    </div>
                </div>
                <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between space-y-6 sm:space-y-8">
                    <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600">
                        <li class="flex items-start gap-3 font-light"><i class="ph ph-buildings text-amber-500 text-base sm:text-lg mt-0.5 shrink-0"></i> <span>Hotel Makkah: <strong class="font-medium text-slate-800">*3 (Anjum / Setaraf)</strong></span></li>
                        <li class="flex items-start gap-3 font-light"><i class="ph ph-buildings text-amber-500 text-base sm:text-lg mt-0.5 shrink-0"></i> <span>Hotel Madinah: <strong class="font-medium text-slate-800">*3 (Diyar Al Taqwa)</strong></span></li>
                        <li class="flex items-start gap-3 font-light"><i class="ph ph-airplane-tilt text-teal-800 text-base sm:text-lg mt-0.5 shrink-0"></i> <span>Maskapai: <strong class="font-medium text-slate-800">Lion Air Direct</strong></span></li>
                    </ul>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                        <div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-wider">Harga Mulai Dari</div>
                            <div class="text-base sm:text-xl font-bold text-teal-950 mt-0.5">Rp 29.500.000 <span class="text-xxs sm:text-xs font-light text-slate-400">/ pax</span></div>
                        </div>
                        <i class="ph ph-arrow-square-out text-xl sm:text-2xl text-slate-300 group-hover:text-amber-500 transition-colors shrink-0"></i>
                    </div>
                </div>
            </div>

            <!-- Kartu 2: Paket Premium -->
            <div class="bg-white rounded-2xl border-2 border-amber-400/60 shadow-xl overflow-hidden flex flex-col lg:-translate-y-3 relative group transition-all duration-300 hover:shadow-2xl">
                <div class="h-44 sm:h-48 relative overflow-hidden bg-slate-950">
                    <img src="https://images.unsplash.com/photo-1591604121669-f2832ac29c97?auto=format&fit=crop&w=500&q=80" alt="Paket Premium" class="w-full h-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/20 to-transparent p-5 sm:p-6 flex flex-col justify-end">
                        <h3 class="text-base sm:text-lg font-serif font-bold text-white">Umrah Premium VIP</h3>
                        <p class="text-xxs sm:text-xs text-amber-400 mt-0.5">Keberangkatan: September 2026</p>
                    </div>
                </div>
                <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between space-y-6 sm:space-y-8">
                    <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600">
                        <li class="flex items-start gap-3 font-light"><i class="ph ph-buildings text-amber-500 text-base sm:text-lg mt-0.5 shrink-0"></i> <span>Hotel Makkah: <strong class="font-medium text-slate-800">*5 (Pulman Zamzam)</strong></span></li>
                        <li class="flex items-start gap-3 font-light"><i class="ph ph-buildings text-amber-500 text-base sm:text-lg mt-0.5 shrink-0"></i> <span>Hotel Madinah: <strong class="font-medium text-slate-800">*5 (Al Aqeeq)</strong></span></li>
                        <li class="flex items-start gap-3 font-light"><i class="ph ph-airplane-tilt text-teal-800 text-base sm:text-lg mt-0.5 shrink-0"></i> <span>Maskapai: <strong class="font-medium text-slate-800">Saudi Arabian Airlines</strong></span></li>
                    </ul>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                        <div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-wider">Harga Mulai Dari</div>
                            <div class="text-base sm:text-xl font-bold text-amber-600 mt-0.5">Rp 36.000.000 <span class="text-xxs sm:text-xs font-light text-slate-400">/ pax</span></div>
                        </div>
                        <i class="ph ph-arrow-square-out text-xl sm:text-2xl text-amber-500 shrink-0"></i>
                    </div>
                </div>
            </div>

            <!-- Kartu 3: Haji Plus -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden flex flex-col hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="h-44 sm:h-48 relative overflow-hidden bg-slate-950">
                    <img src="https://images.unsplash.com/photo-1565552645632-d725f8bfc19a?auto=format&fit=crop&w=500&q=80" alt="Haji Plus" class="w-full h-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/20 to-transparent p-5 sm:p-6 flex flex-col justify-end">
                        <h3 class="text-base sm:text-lg font-serif font-bold text-white">Haji Plus Kuota Resmi</h3>
                        <p class="text-xxs sm:text-xs text-amber-400 mt-0.5">Keberangkatan: Musim Haji 2027</p>
                    </div>
                </div>
                <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between space-y-6 sm:space-y-8">
                    <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600">
                        <li class="flex items-start gap-3 font-light"><i class="ph ph-calendar text-amber-500 text-base sm:text-lg mt-0.5 shrink-0"></i> <span>Durasi Program: <strong class="font-medium text-slate-800">25 Hari</strong></span></li>
                        <li class="flex items-start gap-3 font-light"><i class="ph ph-tent text-amber-500 text-base sm:text-lg mt-0.5 shrink-0"></i> <span>Tenda Mina/Arafah: <strong class="font-medium text-slate-800">VIP Maktab</strong></span></li>
                        <li class="flex items-start gap-3 font-light"><i class="ph ph-users-three text-teal-800 text-base sm:text-lg mt-0.5 shrink-0"></i> <span>Pembimbing: <strong class="font-medium text-slate-800">Sesuai Sunnah (Ustadz Nasional)</strong></span></li>
                    </ul>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                        <div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-wider">Layanan Khusus</div>
                            <div class="text-base sm:text-xl font-bold text-teal-950 mt-0.5">Daftar Antrean Resmi</div>
                        </div>
                        <i class="ph ph-arrow-square-out text-xl sm:text-2xl text-slate-300 group-hover:text-amber-500 transition-colors shrink-0"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= 3. KEUNGGULAN AGEN SECTION ================= -->
<section class="bg-white py-16 sm:py-24 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <!-- Banner Kemitraan (Refaktor Padding & Grid Internal Khusus Mobile) -->
            <div class="bg-linear-to-br from-[#05221E] to-[#0D3D35] rounded-3xl p-6 sm:p-10 text-white space-y-6 sm:space-y-8 shadow-xl relative overflow-hidden border border-teal-800">
                <div class="absolute -right-16 -bottom-16 opacity-[0.03] select-none pointer-events-none">
                    <i class="ph ph-hand-coins text-[200px] sm:text-[300px]"></i>
                </div>
                
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[10px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 uppercase tracking-wider">
                    Peluang Syiar Kemitraan
                </span>
                <h3 class="text-xl sm:text-3xl font-serif font-bold leading-snug">Miliki Penghasilan Mandiri Lewat Program Kemitraan Agen</h3>
                <p class="text-teal-100/70 text-xs sm:text-sm leading-relaxed font-light">
                    Setiap kali Anda berhasil mengajak jamaah mendaftar umrah melalui sistem referral Anda, komisi berjenjang dari Level 1 hingga Level 10 akan langsung mengalir ke dompet digital Anda secara otomatis dan transparan.
                </p>
                
                <!-- Mengubah grid menjadi 1 kolom di HP, 2 kolom dari ukuran tablet (sm) ke atas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="bg-white/5 backdrop-blur-xs rounded-2xl p-4 sm:p-5 border border-white/5">
                        <div class="text-xl sm:text-2xl font-bold text-transparent bg-clip-text bg-linear-to-r from-amber-300 to-amber-100">Rp 2 Juta</div>
                        <div class="text-xxs sm:text-xs text-teal-200/60 mt-1 font-light">Bonus Rekrutmen Langsung</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur-xs rounded-2xl p-4 sm:p-5 border border-white/5">
                        <div class="text-xl sm:text-2xl font-bold text-transparent bg-clip-text bg-linear-to-r from-amber-300 to-amber-100">10 Tingkat</div>
                        <div class="text-xxs sm:text-xs text-teal-200/60 mt-1 font-light">Kedalaman Komisi Jaringan</div>
                    </div>
                </div>
            </div>

            <!-- Sisi Poin Benefit Minimalis -->
            <div class="space-y-6 sm:space-y-8">
                <div class="space-y-2.5 text-center lg:text-left">
                    <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Why Choose Us</span>
                    <h2 class="text-2xl sm:text-3xl font-serif font-bold text-slate-900 tracking-tight leading-tight">Mengapa Harus Menjadi Mitra BMB Travel?</h2>
                </div>
                
                <div class="space-y-5 sm:space-y-6">
                    <!-- Poin 1 -->
                    <div class="flex gap-4 sm:gap-5 items-start group">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-500/5 text-amber-600 flex items-center justify-center shrink-0 border border-amber-500/10 group-hover:bg-amber-500 group-hover:text-slate-950 transition-all duration-300 shadow-xs">
                            <i class="ph ph-certificate text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-teal-900 transition-colors">Legalitas Resmi & Aman</h4>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1 font-light leading-relaxed">Izin resmi Kemenag RI, menjamin keamanan dana jamaah dan kredibilitas nama Anda di mata publik.</p>
                        </div>
                    </div>
                    
                    <!-- Poin 2 -->
                    <div class="flex gap-4 sm:gap-5 items-start group">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-500/5 text-amber-600 flex items-center justify-center shrink-0 border border-amber-500/10 group-hover:bg-amber-500 group-hover:text-slate-950 transition-all duration-300 shadow-xs">
                            <i class="ph ph-monitor text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-teal-900 transition-colors">Dashboard Finansial Canggih</h4>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1 font-light leading-relaxed">Pantau pertumbuhan jamaah rekrutan dan lakukan penarikan bonus komisi kapan pun via sistem digital real-time.</p>
                        </div>
                    </div>
                    
                    <!-- Poin 3 -->
                    <div class="flex gap-4 sm:gap-5 items-start group">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-500/5 text-amber-600 flex items-center justify-center shrink-0 border border-amber-500/10 group-hover:bg-amber-500 group-hover:text-slate-950 transition-all duration-300 shadow-xs">
                            <i class="ph ph-users-three text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-teal-900 transition-colors">Pohon Jaringan Transparan</h4>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1 font-light leading-relaxed">Sistem unilevel matahari yang memudahkan Anda mengontrol kinerja jaringan hingga kedalaman tingkat 10.</p>
                        </div>
                    </div>
                </div>
                
                <div class="pt-2 text-center lg:text-left flex flex-col sm:flex-row justify-center lg:justify-start">
                    <a href="{{ url('/register') }}" class="h-12 px-6 sm:px-8 bg-linear-to-r from-[#0A2E28] to-[#124E44] hover:from-teal-950 hover:to-teal-900 text-white font-medium rounded-xl inline-flex items-center justify-center shadow-lg shadow-teal-950/10 transition-all transform hover:-translate-y-0.5 cursor-pointer text-sm w-full sm:w-auto">
                        Mulai Daftar Sekarang <i class="ph ph-arrow-right ml-2 text-amber-400"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection