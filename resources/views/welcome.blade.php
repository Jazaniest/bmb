@extends('layouts.app')

@section('title', 'PT. Kaukaba Tour & Travel - Solusi Umrah & Haji Premium')

@section('content')
<!-- ================= 1. HERO SECTION ================= -->
<section class="relative bg-linear-to-b from-teal-900 to-teal-950 text-white py-20 lg:py-32 overflow-hidden">
    <!-- Ornamen Estetik Latar Belakang (Gaya Seni Islami/Geometris Abstrak) -->
    <div class="absolute inset-0 opacity-10 flex items-center justify-center pointer-events-none">
        <i class="ph ph-mosque text-[500px]"></i>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Teks Ajakan Utama -->
            <div class="space-y-6 text-center lg:text-left">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-400 border border-amber-500/30 uppercase tracking-wider">
                    <i class="ph-fill ph-star"></i> Biro Perjalanan Umrah Resmi & Terpercaya
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                    Melangkah Pasti Menuju <span class="text-amber-500">Baitullah</span>
                </h1>
                <p class="text-base sm:text-lg text-teal-100 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    Wujudkan ibadah Umrah dan Haji yang mabrur dengan fasilitas premium, bimbingan sesuai Sunnah, dan kepastian jadwal keberangkatan bersama PT. Kaukaba Tour & Travel.
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-2">
                    <a href="#paket" class="h-12 px-6 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl inline-flex items-center shadow-lg transition-transform hover:-translate-y-0.5 cursor-pointer">
                        Lihat Paket Umrah
                    </a>
                    <a href="{{ url('/register') }}" class="h-12 px-6 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl inline-flex items-center border border-white/20 transition-colors cursor-pointer">
                        Gabung Kemitraan Agen
                    </a>
                </div>
            </div>

            <!-- Visual Kanan (Mockup Brosur/Fitur) -->
            <div class="hidden lg:flex justify-center relative">
                <div class="w-72 h-96 bg-slate-800 rounded-3xl border-4 border-slate-700 shadow-2xl overflow-hidden relative transform -rotate-6 transition-transform hover:rotate-0 duration-500">
                    <div class="absolute inset-0 bg-teal-800/50 backdrop-blur-xs p-6 flex flex-col justify-end text-white">
                        <span class="text-amber-400 text-xs font-bold uppercase">Paket Reguler</span>
                        <h4 class="text-xl font-bold mt-1">Umrah Syawal 9 Hari</h4>
                        <p class="text-xs text-teal-200 mt-2">Hotel Bintang 5 | Pesawat Direct Madinah</p>
                    </div>
                </div>
                <div class="w-72 h-96 bg-slate-900 rounded-3xl border-4 border-slate-700 shadow-2xl overflow-hidden absolute top-10 left-44 p-6 flex flex-col justify-end text-white transform rotate-6 transition-transform hover:rotate-0 duration-500">
                    <span class="text-amber-400 text-xs font-bold uppercase">Paket VIP Luxury</span>
                    <h4 class="text-xl font-bold mt-1">Umrah Premium Akhir Tahun</h4>
                    <p class="text-xs text-teal-200 mt-2">Makkah Tower | Bus Eksklusif Saptco</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= 2. PAKET UNGGULAN SECTION ================= -->
<section id="paket" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center space-y-3 mb-16">
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Pilihan Paket Perjalanan Terbaik</h2>
        <p class="text-slate-500 max-w-xl mx-auto text-sm sm:text-base">
            Pilihlah jadwal dan akomodasi yang sesuai dengan kenyamanan ibadah Anda dan keluarga.
        </p>
    </div>

    <!-- Grid Kartu Paket -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Kartu 1 -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col hover:shadow-md transition-shadow">
            <div class="bg-teal-800 text-white p-6 relative">
                <span class="absolute top-4 right-4 px-2.5 py-1 bg-amber-500 text-slate-950 font-bold rounded-md text-xs uppercase">Sisa 5 Kursi</span>
                <h3 class="text-xl font-bold">Umrah Hemat Berkah</h3>
                <p class="text-xs text-teal-200 mt-1">Keberangkatan: Agustus 2026</p>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-between space-y-6">
                <ul class="space-y-3 text-sm text-slate-600">
                    <li class="flex items-center gap-2.5"><i class="ph ph-buildings text-teal-700 text-lg"></i> Hotel Makkah: *3 (Anjum / Setaraf)</li>
                    <li class="flex items-center gap-2.5"><i class="ph ph-buildings text-teal-700 text-lg"></i> Hotel Madinah: *3 (Diyar Al Taqwa)</li>
                    <li class="flex items-center gap-2.5"><i class="ph ph-airplane text-teal-700 text-lg"></i> Maskapai: Lion Air Direct</li>
                </ul>
                <div>
                    <div class="text-xs text-slate-400 font-medium">Harga Mulai Dari</div>
                    <div class="text-2xl font-black text-teal-800 mt-0.5">Rp 29.500.000 <span class="text-xs font-normal text-slate-400">/ pax</span></div>
                </div>
            </div>
        </div>

        <!-- Kartu 2 -->
        <div class="bg-white rounded-2xl border-2 border-teal-700 shadow-md overflow-hidden flex flex-col transform md:-translate-y-2 relative">
            <span class="absolute top-0 left-1/2 -translate-x-1/2 bg-teal-700 text-white font-bold text-xxs tracking-widest uppercase px-4 py-1 rounded-b-lg shadow-xs">Paling Diminati</span>
            <div class="bg-linear-to-r from-teal-800 to-teal-700 text-white p-6 pt-8">
                <h3 class="text-xl font-bold">Umrah Premium VIP</h3>
                <p class="text-xs text-teal-200 mt-1">Keberangkatan: September 2026</p>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-between space-y-6">
                <ul class="space-y-3 text-sm text-slate-600">
                    <li class="flex items-center gap-2.5"><i class="ph ph-buildings text-teal-700 text-lg"></i> Hotel Makkah: *5 (Pulman Zamzam)</li>
                    <li class="flex items-center gap-2.5"><i class="ph ph-buildings text-teal-700 text-lg"></i> Hotel Madinah: *5 (Al Aqeeq)</li>
                    <li class="flex items-center gap-2.5"><i class="ph ph-airplane text-teal-700 text-lg"></i> Maskapai: Saudi Arabian Airlines</li>
                </ul>
                <div>
                    <div class="text-xs text-slate-400 font-medium">Harga Mulai Dari</div>
                    <div class="text-2xl font-black text-amber-600 mt-0.5">Rp 36.000.000 <span class="text-xs font-normal text-slate-400">/ pax</span></div>
                </div>
            </div>
        </div>

        <!-- Kartu 3 -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col hover:shadow-md transition-shadow">
            <div class="bg-teal-800 text-white p-6">
                <h3 class="text-xl font-bold">Haji Plus Kuota Resmi</h3>
                <p class="text-xs text-teal-200 mt-1">Keberangkatan: Musim Haji 2027</p>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-between space-y-6">
                <ul class="space-y-3 text-sm text-slate-600">
                    <li class="flex items-center gap-2.5"><i class="ph ph-calendar text-teal-700 text-lg"></i> Durasi Program: 25 Hari</li>
                    <li class="flex items-center gap-2.5"><i class="ph ph-tent text-teal-700 text-lg"></i> Tenda Mina/Arafah: VIP Maktab</li>
                    <li class="flex items-center gap-2.5"><i class="ph ph-users text-teal-700 text-lg"></i> Pembimbing: Sesuai Sunnah (Ustadz Nasional)</li>
                </ul>
                <div>
                    <div class="text-xs text-slate-400 font-medium">Harga Hubungi CS</div>
                    <div class="text-2xl font-black text-teal-800 mt-0.5">Daftar Antrean Resmi</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= 3. KEUNGGULAN AGEN SECTION ================= -->
<section class="bg-slate-100 py-20 border-t border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Sisi Gambar/Grafik Kecil Promosi -->
            <div class="bg-teal-900 rounded-2xl p-8 text-white space-y-6 shadow-xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 opacity-10"><i class="ph ph-hand-coins text-[250px]"></i></div>
                <h3 class="text-2xl font-bold">Miliki Penghasilan Mandiri Lewat Program Syiar Kemitraan Agen</h3>
                <p class="text-teal-100 text-sm leading-relaxed">
                    Setiap kali Anda berhasil mengajak jamaah mendaftar umrah melalui sistem referral Anda, komisi berjenjang dari Level 1 hingga Level 10 akan langsung mengalir ke dompet digital Anda secara otomatis dan transparan.
                </p>
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="bg-white/10 rounded-xl p-4 border border-white/10">
                        <div class="text-2xl font-black text-amber-400">Rp 2 Juta</div>
                        <div class="text-xs text-teal-100 mt-1">Bonus Rekrutmen Langsung</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4 border border-white/10">
                        <div class="text-2xl font-black text-amber-400">10 Tingkat</div>
                        <div class="text-xs text-teal-100 mt-1">Kedalaman Komisi Jaringan</div>
                    </div>
                </div>
            </div>

            <!-- Sisi Poin Benefit -->
            <div class="space-y-6">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Mengapa Harus Menjadi Mitra Kaukaba Travel?</h2>
                <div class="space-y-4">
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0 border border-teal-100 shadow-xs"><i class="ph ph-certificate text-xl"></i></div>
                        <div>
                            <h4 class="text-base font-bold text-slate-800">Legalitas Resmi & Aman</h4>
                            <p class="text-sm text-slate-500 mt-0.5">Izin resmi Kemenag RI, menjamin keamanan dana jamaah dan kredibilitas nama Anda di mata publik.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0 border border-teal-100 shadow-xs"><i class="ph ph-monitor text-xl"></i></div>
                        <div>
                            <h4 class="text-base font-bold text-slate-800">Dashboard Finansial Canggih</h4>
                            <p class="text-sm text-slate-500 mt-0.5">Pantau pertumbuhan jamaah rekrutan dan lakukan penarikan bonus komisi kapan pun via sistem digital real-time.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0 border border-teal-100 shadow-xs"><i class="ph ph-users-three text-xl"></i></div>
                        <div>
                            <h4 class="text-base font-bold text-slate-800">Pohon Jaringan Transparan</h4>
                            <p class="text-sm text-slate-500 mt-0.5">Sistem unilevel matahari yang memudahkan Anda mengontrol kinerja jaringan hingga kedalaman tingkat 10.</p>
                        </div>
                    </div>
                </div>
                <div class="pt-2 text-center lg:text-left">
                    <a href="{{ url('/register') }}" class="h-11 px-6 bg-teal-700 hover:bg-teal-800 text-white font-semibold rounded-xl inline-flex items-center shadow-md transition-colors cursor-pointer">
                        Mulai Daftar Sekarang <i class="ph ph-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection