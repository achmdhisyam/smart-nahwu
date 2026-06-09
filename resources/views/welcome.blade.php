@extends('layouts.app')

@section('title', 'Smart Nahwu - Asisten Pembelajaran Jurumiyah')

@section('content')
<div class="max-w-6xl mx-auto space-y-16 py-8 md:py-12">
    
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

    <!-- Features Section -->
    <div class="py-12 border-t border-[#e6dec9]">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-[#1b4332]">Fitur Unggulan Smart Nahwu</h2>
            <p class="text-[#4a5d4e] mt-2 font-medium">Didesain khusus untuk mempercepat pemahaman nahwu</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="kitab-box p-8 rounded-2xl text-center group hover:border-[#dfb15b] transition duration-300">
                <div class="w-16 h-16 mx-auto bg-[#1b4332]/10 text-[#1b4332] rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <h3 class="text-xl font-bold text-[#1b4332] mb-3">Analisis I'rab AI</h3>
                <p class="text-[#4a5d4e] text-sm leading-relaxed">
                    Bedah struktur kalimat secara instan. Menampilkan kedudukan kata, harakat akhir, dan alasan nahwunya berdasarkan kitab Jurumiyah.
                </p>
            </div>
            
            <!-- Feature 2 -->
            <div class="kitab-box p-8 rounded-2xl text-center group hover:border-[#dfb15b] transition duration-300">
                <div class="w-16 h-16 mx-auto bg-[#b45309]/10 text-[#b45309] rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                    <i class="fa-solid fa-gamepad"></i>
                </div>
                <h3 class="text-xl font-bold text-[#1b4332] mb-3">Latihan Kuis </h3>
                <p class="text-[#4a5d4e] text-sm leading-relaxed">
                    Evaluasi pemahaman Anda melalui kuis pilihan ganda yang disusun per bab.
                </p>
            </div>
            
            <!-- Feature 3 -->
            <div class="kitab-box p-8 rounded-2xl text-center group hover:border-[#dfb15b] transition duration-300">
                <div class="w-16 h-16 mx-auto bg-[#dfb15b]/20 text-[#b45309] rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="text-xl font-bold text-[#1b4332] mb-3">Riwayat & Statistik Belajar</h3>
                <p class="text-[#4a5d4e] text-sm leading-relaxed">
                    Pantau progres belajar Anda. Semua riwayat analisis kalimat dan perolehan nilai kuis akan disimpan untuk bahan evaluasi.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
