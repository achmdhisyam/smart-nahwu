@extends('layouts.app')

@section('title', 'Dashboard Admin - Smart Nahwu')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1b4332]">Panel Pemantauan Admin</h1>
            <p class="text-sm text-[#5c6f60]">Statistik performa aplikasi, log riwayat analisis, kuis, dan monitoring sistem.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="/admin/chapters" class="px-4 py-2 bg-[#1b4332] hover:bg-[#2d5a45] text-white text-xs font-bold rounded-xl transition border border-[#1b4332]">
                Kelola Bab Jurumiyah
            </a>
            <a href="/admin/rules" class="px-4 py-2 bg-[#b45309] hover:bg-[#9a4004] text-white text-xs font-bold rounded-xl transition border border-[#b45309]">
                Kelola Kaidah
            </a>
        </div>
    </div>

    <!-- Metrik Statistik Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Users Card -->
        <div class="glass bg-white p-6 rounded-3xl border border-[#e6dec9] flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#1b4332]/10 text-[#1b4332] rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-users text-lg"></i>
            </div>
            <div>
                <span class="text-xs text-[#5c6f60] block uppercase font-bold">Total Pengguna</span>
                <span class="text-2xl font-extrabold text-[#133827]">{{ $totalUsers }}</span>
            </div>
        </div>

        <!-- Analyses Card -->
        <div class="glass bg-white p-6 rounded-3xl border border-[#e6dec9] flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#1b4332]/10 text-[#1b4332] rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-file-invoice text-lg"></i>
            </div>
            <div>
                <span class="text-xs text-[#5c6f60] block uppercase font-bold">Kalimat Dianalisis</span>
                <span class="text-2xl font-extrabold text-[#133827]">{{ $totalAnalyses }}</span>
            </div>
        </div>

        <!-- Quizzes Card -->
        <div class="glass bg-white p-6 rounded-3xl border border-[#e6dec9] flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#b45309]/10 text-[#b45309] rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-graduation-cap text-lg"></i>
            </div>
            <div>
                <span class="text-xs text-[#5c6f60] block uppercase font-bold">Total Ujian Kuis</span>
                <span class="text-2xl font-extrabold text-[#133827]">{{ $totalQuizzes }}</span>
            </div>
        </div>

        <!-- Caching Card -->
        <div class="glass bg-white p-6 rounded-3xl border border-[#e6dec9] flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#1b4332]/10 text-[#1b4332] rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-bolt text-lg"></i>
            </div>
            <div>
                <span class="text-xs text-[#5c6f60] block uppercase font-bold">Efisiensi Cache</span>
                <span class="text-2xl font-extrabold text-[#133827]">{{ $cacheEfficiency }}%</span>
            </div>
        </div>
    </div>

    <!-- Dua Kolom Logs Monitoring -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Log Analisis Kalimat Arab -->
        <div class="glass bg-white p-6 rounded-3xl border border-[#e6dec9] space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-[#e6dec9]">
                <h3 class="font-bold text-[#1b4332] text-base">Aktivitas Analisis Kalimat</h3>
                <a href="/admin/analyses" class="text-xs text-[#b45309] hover:underline font-semibold">Lihat Semua</a>
            </div>

            <div class="space-y-3">
                @forelse($recentAnalyses as $analysis)
                    <div class="p-4 bg-[#fcfbfa] rounded-2xl border border-[#e6dec9] flex justify-between items-center gap-4">
                        <div class="space-y-1">
                            <span class="text-[10px] text-[#5c6f60] font-bold block">{{ $analysis->user->name ?? 'Guest/Tamu' }}</span>
                            <p class="text-xl font-arabic text-[#133827] truncate max-w-[200px] sm:max-w-[300px] dir-rtl" dir="rtl">
                                {{ $analysis->input_text }}
                            </p>
                        </div>
                        <span class="text-[10px] text-[#5c6f60] shrink-0">{{ $analysis->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-8 text-sm text-[#5c6f60]">Belum ada aktivitas analisis.</div>
                @endforelse
            </div>
        </div>

        <!-- Log Pengerjaan Kuis Siswa -->
        <div class="glass bg-white p-6 rounded-3xl border border-[#e6dec9] space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-[#e6dec9]">
                <h3 class="font-bold text-[#1b4332] text-base">Aktivitas Percobaan Kuis</h3>
                <a href="/admin/quizzes" class="text-xs text-[#b45309] hover:underline font-semibold">Lihat Semua</a>
            </div>

            <div class="space-y-3">
                @forelse($recentQuizzes as $attempt)
                    <div class="p-4 bg-[#fcfbfa] rounded-2xl border border-[#e6dec9] flex justify-between items-center gap-4">
                        <div class="space-y-1">
                            <span class="text-[10px] text-[#5c6f60] font-bold block">{{ $attempt->user->name }}</span>
                            <p class="text-sm font-bold text-[#133827] truncate max-w-[200px] sm:max-w-[300px]">
                                {{ $attempt->quiz->title }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-2 shrink-0">
                            @php
                                $badgeColor = $attempt->score >= 70 ? 'text-[#385723] bg-[#e2f0d9]' : 'text-[#c65911] bg-[#fce4d6]';
                            @endphp
                            <span class="text-xs font-extrabold px-2 py-0.5 rounded-lg {{ $badgeColor }}">
                                {{ number_format($attempt->score, 0) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-sm text-[#5c6f60]">Belum ada aktivitas kuis.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
