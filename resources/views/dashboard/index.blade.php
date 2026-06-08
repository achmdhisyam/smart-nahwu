@extends('layouts.app')

@section('title', 'Dashboard Santri - Smart Nahwu')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <div class="text-center space-y-2 mb-10">
        <h1 class="text-3xl font-extrabold text-[#1b4332]">
            Selamat Datang, {{ auth()->user()->name }}!
        </h1>
        <p class="text-[#4a5d4e] text-sm">
            Pantau progres belajar dan hasil analisis Anda di sini.
        </p>
    </div>

    <!-- Statistik Belajar -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="kitab-box p-6 rounded-2xl flex items-center space-x-6">
            <div class="w-14 h-14 rounded-full bg-[#1b4332]/10 text-[#1b4332] flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-microscope"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-[#5c6f60] uppercase tracking-wider">Total Analisis</p>
                <p class="text-3xl font-extrabold text-[#1b4332]">{{ $totalAnalisis }}</p>
            </div>
        </div>
        
        <div class="kitab-box p-6 rounded-2xl flex items-center space-x-6">
            <div class="w-14 h-14 rounded-full bg-[#dfb15b]/20 text-[#b45309] flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-gamepad"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-[#5c6f60] uppercase tracking-wider">Kuis Dikerjakan</p>
                <p class="text-3xl font-extrabold text-[#1b4332]">{{ $totalKuis }}</p>
            </div>
        </div>

        <div class="kitab-box p-6 rounded-2xl flex items-center space-x-6">
            <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-[#5c6f60] uppercase tracking-wider">Rata-rata Nilai</p>
                <p class="text-3xl font-extrabold text-[#1b4332]">{{ number_format($rataKuis, 1) }}</p>
            </div>
        </div>
    </div>

    <!-- Aktivitas & Rekomendasi -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Aktivitas Analisis Terakhir -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-[#1b4332]">Analisis Terakhir</h2>
                <a href="{{ route('riwayat.index') }}" class="text-xs font-bold text-[#b45309] hover:underline">Lihat Semua</a>
            </div>
            
            <div class="kitab-box rounded-2xl p-6 overflow-hidden min-h-[300px]">
                @if($recentAnalisis->isEmpty())
                    <div class="text-center py-12 flex flex-col items-center justify-center h-full">
                        <div class="text-[#dfb15b]/50 text-6xl mb-4"><i class="fa-solid fa-box-open"></i></div>
                        <p class="text-[#5c6f60] text-sm">Belum ada riwayat analisis.</p>
                        <a href="{{ route('analisis.index') }}" class="inline-block mt-4 px-5 py-2.5 bg-[#1b4332] text-white rounded-xl text-xs font-bold hover:bg-[#2d5a45] transition shadow-md">Mulai Analisis Pertama</a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($recentAnalisis as $riwayat)
                            <div class="flex items-center justify-between p-4 bg-white/60 border border-[#e6dec9] rounded-xl hover:border-[#dfb15b] hover:shadow-sm transition group">
                                <div class="flex-1 truncate">
                                    <p class="font-arabic text-xl text-right text-[#1b4332] group-hover:text-[#b45309] transition" dir="rtl">{{ Str::limit($riwayat->teks_asli, 50) }}</p>
                                    <p class="text-[10px] text-[#5c6f60] mt-1 font-semibold">{{ $riwayat->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="{{ route('analisis.show', App\Helpers\HashidsHelper::encode($riwayat->id)) }}" class="w-8 h-8 rounded-full bg-[#1b4332]/10 text-[#1b4332] hover:bg-[#1b4332] hover:text-white flex items-center justify-center transition">
                                        <i class="fa-solid fa-chevron-right text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Riwayat Kuis Terakhir -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-[#1b4332]">Kuis Terakhir</h2>
                <a href="{{ route('kuis.index') }}" class="text-xs font-bold text-[#b45309] hover:underline">Mulai Kuis Baru</a>
            </div>
            
            <div class="kitab-box rounded-2xl p-6 overflow-hidden min-h-[300px]">
                @if($recentKuis->isEmpty())
                    <div class="text-center py-12 flex flex-col items-center justify-center h-full">
                        <div class="text-[#dfb15b]/50 text-6xl mb-4"><i class="fa-solid fa-graduation-cap"></i></div>
                        <p class="text-[#5c6f60] text-sm">Belum ada kuis yang dikerjakan.</p>
                        <a href="{{ route('kuis.index') }}" class="inline-block mt-4 px-5 py-2.5 bg-[#b45309] text-white rounded-xl text-xs font-bold hover:bg-[#9a4004] transition shadow-md">Lihat Daftar Kuis</a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($recentKuis as $riwayat)
                            <div class="flex items-center justify-between p-4 bg-white/60 border border-[#e6dec9] rounded-xl hover:border-[#dfb15b] hover:shadow-sm transition">
                                <div>
                                    <p class="text-sm font-bold text-[#1b4332]">{{ $riwayat->kuis->judul ?? 'Kuis' }}</p>
                                    <p class="text-[10px] text-[#5c6f60] font-semibold mt-0.5">
                                        <i class="fa-solid fa-book-open mr-1 text-[#dfb15b]"></i>
                                        {{ $riwayat->kuis->bab->nama_bab ?? '' }} • {{ $riwayat->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-xl font-black {{ $riwayat->skor >= 70 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $riwayat->skor }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
