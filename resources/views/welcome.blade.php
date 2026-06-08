@extends('layouts.app')

@section('title', 'Smart Nahwu - Asisten Pembelajaran Jurumiyah')

@section('content')
<div class="max-w-6xl mx-auto space-y-12 md:space-y-16 py-8 md:py-12">
    
    <!-- Hero Section -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-12">
        <div class="flex-1 space-y-6 text-center md:text-left">

            <h1 class="text-4xl md:text-6xl font-extrabold text-[#1b4332] leading-tight">
                Pahami nahwu <br class="hidden md:block">Lebih Mudah & Cepat
            </h1>
            <p class="text-[#4a5d4e] text-lg max-w-xl mx-auto md:mx-0">
                Smart Nahwu adalah asisten cerdas berbasis AI untuk menganalisis kedudukan I'rab dan perubahan Shorof secara instan, dilengkapi kuis interaktif sesuai kaidah Jurumiyah.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center gap-4 justify-center md:justify-start pt-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-[#b45309] hover:bg-[#9a4004] text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 text-center">
                    Mulai Belajar Gratis
                </a>
                <a href="{{ route('analisis.index') }}" class="w-full sm:w-auto px-8 py-4 bg-white border-2 border-[#1b4332] text-[#1b4332] hover:bg-[#1b4332] hover:text-white font-bold rounded-xl shadow-md transition text-center flex items-center justify-center gap-2">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span>Coba Analisis Nahwu</span>
                </a>
            </div>
        </div>
        
        <div class="flex-1 relative w-full max-w-md mx-auto md:max-w-none">
            <!-- Decorative Background blob -->
            <div class="absolute inset-0 bg-[#dfb15b]/20 rounded-full blur-3xl transform scale-110"></div>
            <!-- Illustration / UI Mockup -->
            <div class="kitab-box p-6 rounded-2xl relative z-10 transform md:rotate-3 shadow-2xl border-2 border-[#dfb15b]/30 bg-white">
                <div class="border-b border-[#e6dec9] pb-4 mb-4 flex items-center justify-between">
                    <div class="flex gap-2">
                        <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    </div>
                    <span class="text-xs text-[#5c6f60] font-mono font-semibold">analisis-nahwu</span>
                </div>
                <div class="text-right font-arabic text-3xl leading-relaxed text-[#1b4332]" dir="rtl">
                    الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ
                </div>
                <div class="mt-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="h-8 bg-[#1b4332]/10 rounded w-16 flex-shrink-0"></div>
                        <div class="h-3 bg-[#e6dec9] rounded w-full"></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="h-8 bg-[#1b4332]/10 rounded w-16 flex-shrink-0"></div>
                        <div class="h-3 bg-[#e6dec9] rounded w-3/4"></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="h-8 bg-[#1b4332]/10 rounded w-16 flex-shrink-0"></div>
                        <div class="h-3 bg-[#e6dec9] rounded w-5/6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Portal (Bespoke Book Index Style) -->
    <div class="space-y-5 bg-[#fdfbf7] pt-4 pb-5 px-5 md:pt-5 md:pb-6 md:px-6 rounded-2xl border border-[#e6dec9] shadow-sm relative overflow-hidden">
        <!-- Decorative subtle pattern overlay -->
        <div class="absolute inset-0 opacity-[0.02] bg-[radial-gradient(#1b4332_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

        <div class="text-center md:text-left border-b border-[#e6dec9]/60 pb-3.5 relative z-10">
            <p class="text-xl font-extrabold text-[#1b4332]">Langkah Cepat Belajar Nahwu</p>
        </div>

        <div class="divide-y divide-[#e6dec9]/60 relative z-10">
            <!-- Step 1 -->
            <div class="py-5 first:pt-0 last:pb-0 flex flex-col md:flex-row md:items-center justify-between gap-5 group">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-[#1b4332]/10 text-[#1b4332] flex items-center justify-center text-base flex-shrink-0 mt-0.5 transition-all duration-300 group-hover:bg-[#1b4332] group-hover:text-white">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-bold text-[#1b4332]">Belajar Al-Ajurrumiyyah</h4>
                        <p class="text-[#5c6f60] text-sm max-w-xl">Pelajari materi Nahwu secara terstruktur dari Bab Kalam hingga Bab Majrurat.</p>
                    </div>
                </div>
                <a href="{{ route('belajar.index') }}" class="inline-flex items-center justify-center gap-2 w-full md:w-auto px-5 py-2.5 bg-[#1b4332] hover:bg-[#b45309] text-[#fbf8f1] hover:text-white text-xs font-bold rounded-xl transition-all duration-300 shadow-sm group-hover:shadow text-center">
                    <span>Pelajari Materi</span>
                    <i class="fa-solid fa-arrow-right-long text-[10px] group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>

            <!-- Step 2 -->
            <div class="py-5 flex flex-col md:flex-row md:items-center justify-between gap-5 group">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-[#b45309]/10 text-[#b45309] flex items-center justify-center text-base flex-shrink-0 mt-0.5 transition-all duration-300 group-hover:bg-[#b45309] group-hover:text-white">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-bold text-[#1b4332]">Analisis Kalimat AI</h4>
                        <p class="text-[#5c6f60] text-sm max-w-xl">Bedah kedudukan kata, status I'rab, dan alasannya secara instan menggunakan kecerdasan buatan.</p>
                    </div>
                </div>
                <a href="{{ route('analisis.index') }}" class="inline-flex items-center justify-center gap-2 w-full md:w-auto px-5 py-2.5 bg-[#1b4332] hover:bg-[#b45309] text-[#fbf8f1] hover:text-white text-xs font-bold rounded-xl transition-all duration-300 shadow-sm group-hover:shadow text-center">
                    <span>Mulai Analisis</span>
                    <i class="fa-solid fa-arrow-right-long text-[10px] group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>

            <!-- Step 3 -->
            <div class="py-5 last:pb-0 flex flex-col md:flex-row md:items-center justify-between gap-5 group">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-[#dfb15b]/20 text-amber-800 flex items-center justify-center text-base flex-shrink-0 mt-0.5 transition-all duration-300 group-hover:bg-[#dfb15b] group-hover:text-[#1b4332]">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-bold text-[#1b4332]">Latihan Kuis</h4>
                        <p class="text-[#5c6f60] text-sm max-w-xl">Uji pemahaman materi Nahwu Anda melalui latihan kuis per bab.</p>
                    </div>
                </div>
                @auth
                    <a href="{{ route('kuis.index') }}" class="inline-flex items-center justify-center gap-2 w-full md:w-auto px-5 py-2.5 bg-[#1b4332] hover:bg-[#b45309] text-[#fbf8f1] hover:text-white text-xs font-bold rounded-xl transition-all duration-300 shadow-sm group-hover:shadow text-center">
                @else
                    <a href="javascript:void(0)" onclick="showLoginAlert()" class="inline-flex items-center justify-center gap-2 w-full md:w-auto px-5 py-2.5 bg-[#1b4332] hover:bg-[#b45309] text-[#fbf8f1] hover:text-white text-xs font-bold rounded-xl transition-all duration-300 shadow-sm group-hover:shadow text-center">
                @endauth
                    <span>Mulai Latihan</span>
                    <i class="fa-solid fa-arrow-right-long text-[10px] group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 border-t border-[#e6dec9]">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-[#1b4332]">Fitur Unggulan Smart Nahwu</h2>
            <p class="text-[#4a5d4e] mt-2 font-medium">Didesain khusus untuk mempercepat pemahaman nahwu</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Feature 1: Belajar Jurumiyah -->
            <div class="kitab-box p-6 rounded-2xl text-center group hover:border-[#dfb15b] transition duration-300 bg-white">
                <div class="w-14 h-14 mx-auto bg-[#1b4332]/10 text-[#1b4332] rounded-2xl flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-book-quran"></i>
                </div>
                <h3 class="text-lg font-bold text-[#1b4332] mb-2.5">Belajar Al-Ajurrumiyyah</h3>
                <p class="text-[#4a5d4e] text-xs leading-relaxed">
                    Pelajari kaidah tata bahasa Arab secara bertahap langsung dari naskah asli Kitab Matan Al-Ajurrumiyyah yang lengkap.
                </p>
            </div>

            <!-- Feature 2: Analisis I'rab AI -->
            <div class="kitab-box p-6 rounded-2xl text-center group hover:border-[#dfb15b] transition duration-300 bg-white">
                <div class="w-14 h-14 mx-auto bg-[#b45309]/10 text-[#b45309] rounded-2xl flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <h3 class="text-lg font-bold text-[#1b4332] mb-2.5">Analisis I'rab AI</h3>
                <p class="text-[#4a5d4e] text-xs leading-relaxed">
                    Bedah struktur kalimat secara instan. Menampilkan kedudukan kata, harakat akhir, dan alasannya berdasarkan kitab Jurumiyah.
                </p>
            </div>
            
            <!-- Feature 3: Latihan Kuis -->
            <div class="kitab-box p-6 rounded-2xl text-center group hover:border-[#dfb15b] transition duration-300 bg-white">
                <div class="w-14 h-14 mx-auto bg-amber-500/10 text-amber-700 rounded-2xl flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-gamepad"></i>
                </div>
                <h3 class="text-lg font-bold text-[#1b4332] mb-2.5">Latihan Kuis</h3>
                <p class="text-[#4a5d4e] text-xs leading-relaxed">
                    Evaluasi pemahaman materi Anda melalui berbagai latihan kuis pilihan ganda terstruktur yang disediakan di setiap bab.
                </p>
            </div>
            
            <!-- Feature 4: Riwayat & Statistik -->
            <div class="kitab-box p-6 rounded-2xl text-center group hover:border-[#dfb15b] transition duration-300 bg-white">
                <div class="w-14 h-14 mx-auto bg-[#dfb15b]/20 text-[#b45309] rounded-2xl flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="text-lg font-bold text-[#1b4332] mb-2.5">Riwayat & Statistik</h3>
                <p class="text-[#4a5d4e] text-xs leading-relaxed">
                    Pantau progres belajar Anda. Semua riwayat analisis kalimat dan perolehan nilai kuis akan disimpan untuk bahan evaluasi.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
