@extends('layouts.app')

@section('title', 'Modul Belajar Matan Al-Ajurrumiyyah - Smart Nahwu')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 py-8">
    <!-- Header -->
    <div class="text-center space-y-3">
        <span class="px-3 py-1 bg-[#1b4332]/10 text-[#1b4332] text-xs font-semibold rounded-full uppercase tracking-wider">
            E-Book & Modul Interaktif
        </span>
        <h1 class="text-4xl font-extrabold text-[#1b4332] tracking-tight">
            Kitab Matan Al-Ajurrumiyyah
        </h1>
        <p class="text-[#4a5d4e] max-w-xl mx-auto text-sm leading-relaxed">
            Pelajari tata bahasa Arab (Nahwu) secara bertahap mulai dari konsep kalam, i'rab, hingga pembahasan isim-isim yang di-rafa'kan, di-nasabkan, dan di-khafadkan.
        </p>
    </div>

    <!-- Peta Belajar Timeline -->
    <div class="relative pl-6 border-l-2 border-[#e6dec9]/80 space-y-10 ml-4 md:ml-6">
        @forelse($chapters as $chapter)
            <div class="relative">
                <!-- Timeline Dot Indicator -->
                <span class="absolute -left-[35px] top-1.5 w-6 h-6 rounded-full flex items-center justify-center border-2 border-white shadow-sm
                    @if($chapter->status_belajar === 'selesai')
                        bg-emerald-600 text-white
                    @elseif($chapter->status_belajar === 'belajar')
                        bg-amber-500 text-white
                    @else
                        bg-[#e6dec9] text-[#5c6f60]
                    @endif
                ">
                    @if($chapter->status_belajar === 'selesai')
                        <i class="fa-solid fa-check text-[10px]"></i>
                    @else
                        <span class="text-[10px] font-bold">{{ $chapter->nomor_urut }}</span>
                    @endif
                </span>

                <!-- Chapter Card -->
                <div class="kitab-box p-6 rounded-2xl bg-white border border-[#e6dec9] shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2.5">
                                <h2 class="text-xl font-bold text-[#1b4332]">
                                    {{ $chapter->judul }}
                                </h2>
                                @if($chapter->status_belajar === 'selesai')
                                    <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded uppercase tracking-wider">Selesai</span>
                                @elseif($chapter->status_belajar === 'belajar')
                                    <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-bold rounded uppercase tracking-wider">Dipelajari</span>
                                @endif
                            </div>
                            <p class="text-[#4a5d4e] text-sm leading-relaxed line-clamp-2">
                                {{ $chapter->definisi }}
                            </p>
                        </div>

                        <div>
                            <a 
                                href="{{ route('belajar.show', $chapter->hash) }}"
                                class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold px-5 py-2.5 rounded-xl text-sm transition shadow-sm"
                            >
                                <span>Mulai Belajar</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Sub Chapters if available -->
                    @if($chapter->anak && $chapter->anak->count() > 0)
                        <div class="mt-5 pt-4 border-t border-[#e6dec9]/50 space-y-3">
                            <span class="block text-xs font-semibold text-[#5c6f60] uppercase tracking-wider mb-2">Sub Bab Pembahasan</span>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($chapter->anak as $sub)
                                    <a 
                                        href="{{ route('belajar.show', $sub->hash) }}"
                                        class="flex items-center justify-between p-3.5 rounded-xl border border-[#e6dec9]/60 bg-[#fdfbf7] hover:bg-[#f5ebd3] hover:border-[#1b4332]/30 transition group"
                                    >
                                        <div class="flex items-center gap-3">
                                            <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold
                                                @if($sub->status_belajar === 'selesai')
                                                    bg-emerald-100 text-emerald-800
                                                @elseif($sub->status_belajar === 'belajar')
                                                    bg-amber-100 text-amber-800
                                                @else
                                                    bg-[#e6dec9]/50 text-[#5c6f60]
                                                @endif
                                            ">
                                                {{ $sub->nomor_urut }}
                                            </span>
                                            <span class="text-sm font-semibold text-[#2b3a32] group-hover:text-[#1b4332] transition">
                                                {{ $sub->judul }}
                                            </span>
                                        </div>
                                        <i class="fa-solid fa-chevron-right text-[10px] text-[#5c6f60] group-hover:text-[#1b4332] transition"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12 kitab-box bg-white rounded-2xl border border-[#e6dec9]">
                <i class="fa-solid fa-book-open text-4xl text-[#e6dec9] mb-3"></i>
                <p class="text-[#5c6f60] font-semibold">Belum ada materi belajar yang ditambahkan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
