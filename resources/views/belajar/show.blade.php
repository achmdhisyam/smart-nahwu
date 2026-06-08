@extends('layouts.app')

@section('title', $chapter->judul . ' - Smart Nahwu')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 space-y-8">
    <!-- Breadcrumbs & Back Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('belajar.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#fcfbfa] hover:bg-[#f5f2eb] text-[#1b4332] text-xs font-bold rounded-xl border border-[#e6dec9] transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Belajar Al-Ajurrumiyyah</span>
        </a>

        @if(Auth::check())
            <div class="flex items-center gap-3">
                @if($progress && $progress->status === 'selesai')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full border border-emerald-200">
                        <i class="fa-solid fa-circle-check"></i> Selesai Dipelajari
                    </span>
                @else
                    <form action="{{ route('belajar.complete', $hash) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 bg-white hover:bg-emerald-50 text-emerald-800 text-xs font-bold rounded-full border border-emerald-200 shadow-sm transition">
                            <i class="fa-solid fa-circle-notch"></i> Tandai Selesai Belajar
                        </button>
                    </form>
                @endif
            </div>
        @endif
    </div>

    <!-- Chapter Box Paper Style -->
    <div class="kitab-box p-8 md:p-10 rounded-2xl bg-white border border-[#e6dec9] shadow-sm space-y-8 relative overflow-hidden">
        <!-- Decorative Header -->
        <div class="text-center space-y-2 border-b border-[#e6dec9]/60 pb-6">
            @if($chapter->induk)
                <span class="text-xs font-semibold text-[#5c6f60] uppercase tracking-wider">
                    Bab: {{ $chapter->induk->judul }}
                </span>
            @endif
            <h1 class="text-3xl font-extrabold text-[#1b4332]">
                {{ $chapter->judul }}
            </h1>
            <p class="text-xs text-[#5c6f60] font-mono">
                Nomor Urut: {{ $chapter->nomor_urut }}
            </p>
        </div>

        <!-- Matan Al-Ajurrumiyyah (Jika Ada) -->
        @if(!empty($arabicMatan))
            <div class="space-y-3">
                <h3 class="text-lg font-bold text-[#1b4332] flex items-center gap-2">
                    <i class="fa-solid fa-book-open text-sm text-[#b45309]"></i>
                    <span>Matan Al-Ajurrumiyyah</span>
                </h3>
                <div class="p-6 md:p-8 bg-[#f5f2eb] rounded-xl border border-[#e6dec9] text-[#1b4332] text-right font-serif text-2xl md:text-3xl leading-loose shadow-inner relative" dir="rtl">
                    {{ $arabicMatan }}
                </div>
            </div>
        @endif

        <!-- Definisi / Penjelasan -->
        <div class="space-y-3">
            <h3 class="text-lg font-bold text-[#1b4332] flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-sm text-[#b45309]"></i>
                <span>Definisi & Penjelasan</span>
            </h3>
            <div class="p-5 bg-[#fdfbf7] rounded-xl border border-[#e6dec9]/50 text-[#2b3a32] text-sm leading-relaxed whitespace-pre-line">
                {{ $chapter->definisi }}
            </div>
        </div>

        <!-- Kaidah Gramatika (Jika Ada) -->
        @if($chapter->kaidahGramatika && $chapter->kaidahGramatika->count() > 0)
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-[#1b4332] flex items-center gap-2">
                    <i class="fa-solid fa-scroll text-sm text-[#b45309]"></i>
                    <span>Kaidah Gramatika</span>
                </h3>
                <div class="space-y-3">
                    @foreach($chapter->kaidahGramatika as $kaidah)
                        <div class="p-4 bg-white border border-[#e6dec9]/60 rounded-xl">
                            <p class="text-sm text-[#2b3a32] leading-relaxed whitespace-pre-line">
                                {{ $kaidah->teks_kaidah }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Huruf Tugas (Jika Ada) -->
        @if($chapter->hurufTugas && $chapter->hurufTugas->count() > 0)
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-[#1b4332] flex items-center gap-2">
                    <i class="fa-solid fa-key text-sm text-[#b45309]"></i>
                    <span>Huruf Tugas & Amil</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($chapter->hurufTugas as $huruf)
                        <div class="p-4 bg-amber-50/30 border border-[#e6dec9]/60 rounded-xl flex items-center justify-between gap-4">
                            <div>
                                <span class="block text-xs font-bold text-[#5c6f60] uppercase tracking-wider">Jenis: {{ $huruf->jenis }}</span>
                                <span class="block text-sm font-semibold text-[#2b3a32] mt-1">{{ $huruf->arti }}</span>
                            </div>
                            <span class="text-2xl font-bold text-[#1b4332] font-serif" dir="rtl">
                                {{ $huruf->teks_arab }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Contoh Gramatika / Analisis (Jika Ada) -->
        @if($chapter->contohGramatika && $chapter->contohGramatika->count() > 0)
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-[#1b4332] flex items-center gap-2">
                    <i class="fa-solid fa-pen-nib text-sm text-[#b45309]"></i>
                    <span>Contoh Kalimat & Terjemahan</span>
                </h3>
                <div class="overflow-hidden border border-[#e6dec9]/60 rounded-xl">
                    <table class="w-full text-left border-collapse bg-white">
                        <thead>
                            <tr class="bg-[#fdfbf7] border-b border-[#e6dec9]/60">
                                <th class="p-4 text-xs font-bold text-[#1b4332] uppercase tracking-wider w-1/2 text-right">Teks Arab</th>
                                <th class="p-4 text-xs font-bold text-[#1b4332] uppercase tracking-wider w-1/2">Terjemahan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e6dec9]/40">
                            @foreach($chapter->contohGramatika as $contoh)
                                <tr>
                                    <td class="p-4 text-right font-serif text-2xl text-[#1b4332] leading-loose" dir="rtl">
                                        {{ $contoh->teks_arab }}
                                    </td>
                                    <td class="p-4 text-sm text-[#4a5d4e] leading-relaxed">
                                        {{ $contoh->terjemahan }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <!-- Quiz CTA Section -->
    <div class="kitab-box p-6 rounded-2xl bg-emerald-50 border border-emerald-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="space-y-1 text-center md:text-left">
            <h4 class="text-base font-bold text-emerald-900">Uji Pemahaman Anda!</h4>
            <p class="text-emerald-700 text-xs">Evaluasi pemahaman materi bab ini dengan mengikuti kuis interaktif.</p>
        </div>
        @if(Auth::check())
            <a 
                href="{{ route('kuis.show', $chapter->id) }}"
                class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition"
            >
                <i class="fa-solid fa-gamepad"></i>
                <span>Mulai Kuis</span>
            </a>
        @else
            <a 
                href="{{ route('login') }}"
                class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-amber-600 hover:bg-amber-700 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition"
            >
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Login untuk Kuis</span>
            </a>
        @endif
    </div>

    <!-- Chapter Navigation -->
    <div class="flex items-center justify-between border-t border-[#e6dec9]/60 pt-6">
        @if($prevChapter)
            <a 
                href="{{ route('belajar.show', $prevChapter->hash) }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-[#1b4332] hover:underline"
            >
                <i class="fa-solid fa-chevron-left text-xs"></i>
                <span>Sebelumnya: {{ $prevChapter->judul }}</span>
            </a>
        @else
            <div></div>
        @endif

        @if($nextChapter)
            <a 
                href="{{ route('belajar.show', $nextChapter->hash) }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-[#1b4332] hover:underline ml-auto"
            >
                <span>Selanjutnya: {{ $nextChapter->judul }}</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </a>
        @endif
    </div>
</div>
@endsection
