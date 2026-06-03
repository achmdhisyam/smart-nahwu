@extends('layouts.app')

@section('title', 'Hasil Analisis - Smart Nahwu')

@section('content')
<div class="max-w-5xl mx-auto space-y-8" x-data="{ selectedIndex: 0 }">
    <!-- Breadcrumb / Back button -->
    <div>
        <a href="/analyze" class="text-sm font-semibold text-[#1b4332] hover:text-[#b45309] flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Input</span>
        </a>
    </div>

    <!-- Teks Arab Utama & Jenis Kalimat -->
    <div class="kitab-box rounded-xl p-8 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-[#e6dec9] pb-4 gap-4">
            <div class="space-y-1">
                <span class="text-xs font-bold text-[#b45309] uppercase tracking-wider block">Teks Arab Asli:</span>
                <p class="text-2xl font-arabic text-[#5c6f60] text-right md:text-left" dir="rtl">{{ $history->input_text }}</p>
            </div>
            <div class="shrink-0">
                <span class="px-3 py-1 bg-[#1b4332]/10 border border-[#1b4332]/25 text-[#1b4332] rounded-full text-xs font-bold uppercase tracking-wider">
                    Struktur: {{ $analysis['sentence_structure'] }}
                </span>
            </div>
        </div>

        <div class="space-y-4">
            <div class="text-center">
                <span class="text-xs font-bold text-[#b45309] uppercase tracking-wider block mb-2">Teks Arab Berharakat (Interaktif):</span>
                <!-- Render Kalimat Berharakat Interaktif -->
                <div class="flex flex-wrap justify-center gap-4 dir-rtl" dir="rtl">
                    @foreach($analysis['word_by_word_analysis'] as $index => $item)
                        @php
                            $irabStatus = strtolower($item['irab_status']);
                            $colorClass = match($irabStatus) {
                                'rafa\'' => 'bg-[#e2f0d9] text-[#385723] border-[#c5e0b4] hover:bg-[#d5ebd0]',
                                'nashab' => 'bg-[#fce4d6] text-[#c65911] border-[#f8cbad] hover:bg-[#fad8c2]',
                                'jar', 'jar/khafadh' => 'bg-[#fff2cc] text-[#7f6000] border-[#ffe599] hover:bg-[#fff9e6]',
                                'jazm' => 'bg-[#ededed] text-[#595959] border-[#d9d9d9] hover:bg-[#e3e3e3]',
                                default => 'bg-[#f2f2f2] text-[#7f7f7f] border-[#d9d9d9] hover:bg-[#e6e6e6]',
                            };
                        @endphp
                        <button 
                            @click="selectedIndex = {{ $index }}"
                            :class="selectedIndex === {{ $index }} ? 'ring-2 ring-[#b45309] scale-105' : ''"
                            class="px-4 py-2 border rounded-2xl text-4xl font-arabic transition duration-200 cursor-pointer shadow-md {{ $colorClass }}"
                        >
                            {{ $item['vocalized_word'] ?? $item['word'] }}
                        </button>
                    @endforeach
                </div>
            </div>
            
            @if(!empty($analysis['vocalized_sentence']))
                <div class="bg-[#fcfbfa] p-4 rounded-xl border border-[#e6dec9] text-center space-y-1 mt-4">
                    <span class="text-xs font-bold text-[#b45309] uppercase tracking-wider block">Kalimat Lengkap Berharakat:</span>
                    <p class="text-3xl font-arabic text-[#133827] leading-relaxed" dir="rtl">{{ $analysis['vocalized_sentence'] }}</p>
                </div>
            @endif
        </div>
        
        <p class="text-xs text-center text-[#5c6f60]">Klik pada salah satu kata berharakat di atas untuk memfokuskan detail analisis.</p>
    </div>

    <!-- Layout Vertikal: Detail Analisis dan Rujukan Bab -->
    <div class="space-y-8">
        <!-- Detail Analisis Kata Fokus (Alpine Dynamic Card) -->
        <div class="space-y-6">
            @foreach($analysis['word_by_word_analysis'] as $index => $item)
                @php
                    $irabStatus = strtolower($item['irab_status']);
                    $badgeColor = match($irabStatus) {
                        'rafa\'' => 'bg-[#e2f0d9] text-[#385723] border border-[#c5e0b4]',
                        'nashab' => 'bg-[#fce4d6] text-[#c65911] border border-[#f8cbad]',
                        'jar', 'jar/khafadh' => 'bg-[#fff2cc] text-[#7f6000] border border-[#ffe599]',
                        'jazm' => 'bg-[#ededed] text-[#595959] border border-[#d9d9d9]',
                        default => 'bg-[#f2f2f2] text-[#7f7f7f] border border-[#d9d9d9]',
                    };
                @endphp
                <div 
                    x-show="selectedIndex === {{ $index }}" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="kitab-box rounded-xl p-6 sm:p-8 space-y-6"
                >
                    <!-- Judul Kata Fokus -->
                    <div class="flex items-center justify-between pb-4 border-b border-[#e6dec9]">
                        <div class="flex items-center space-x-3">
                            <span class="text-[#4a5d4e] text-sm">Fokus Analisis:</span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-lg uppercase tracking-wider {{ $badgeColor }}">
                                {{ $item['irab_status'] }}
                            </span>
                        </div>
                        <div class="text-right">
                            <h2 class="text-4xl font-arabic text-[#1b4332]">{{ $item['vocalized_word'] ?? $item['word'] }}</h2>
                            @if(isset($item['vocalized_word']) && $item['vocalized_word'] !== $item['word'])
                                <span class="text-xs text-[#5c6f60] font-arabic block mt-1">Teks Asli: {{ $item['word'] }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- List Detail Vertikal -->
                    <div class="space-y-1">
                        <!-- Jenis Kata -->
                        <div class="flex border-b border-[#e6dec9]/60 py-3">
                            <span class="text-[#5c6f60] text-sm w-44 font-semibold shrink-0">Jenis Kata</span>
                            <span class="text-[#133827] text-sm font-bold">{{ $item['part_of_speech'] }}</span>
                        </div>

                        <!-- Status I'rab -->
                        @if($item['irab_status'] !== '-' && !empty($item['irab_status']))
                            <div class="flex border-b border-[#e6dec9]/60 py-3">
                                <span class="text-[#5c6f60] text-sm w-44 font-semibold shrink-0">Status I'rab</span>
                                <span class="text-[#133827] text-sm font-bold">{{ $item['irab_status'] }}</span>
                            </div>
                        @endif

                        <!-- Tanda I'rab -->
                        @if($item['irab_marker'] !== '-' && !empty($item['irab_marker']))
                            <div class="flex border-b border-[#e6dec9]/60 py-3">
                                <span class="text-[#5c6f60] text-sm w-44 font-semibold shrink-0">Tanda I'rab</span>
                                <span class="text-[#133827] text-sm font-bold">{{ $item['irab_marker'] }}</span>
                            </div>
                        @endif

                        <!-- Kedudukan (I'rab) -->
                        @if($item['syntactic_role'] !== '-' && !empty($item['syntactic_role']))
                            <div class="flex border-b border-[#e6dec9]/60 py-3">
                                <span class="text-[#5c6f60] text-sm w-44 font-semibold shrink-0">Kedudukan (I'rab)</span>
                                <span class="text-[#133827] text-sm font-bold">{{ $item['syntactic_role'] }}</span>
                            </div>
                        @endif

                        <!-- Shorof / Morfologi (Dipecah jika ada isi) -->
                        @if($item['morphology'] !== '-' && !empty($item['morphology']) && strtolower(trim($item['morphology'])) !== 'tidak ada' && strtolower(trim($item['morphology'])) !== 'bukan fi\'il/isim')
                            @php
                                $parts = explode('|', $item['morphology']);
                            @endphp
                            @foreach($parts as $part)
                                @php
                                    $subparts = explode(':', $part, 2);
                                    $label = trim($subparts[0] ?? 'Morfologi');
                                    $val = trim($subparts[1] ?? '');
                                @endphp
                                @if(!empty($val) && $val !== '-')
                                    <div class="flex border-b border-[#e6dec9]/60 py-3">
                                        <span class="text-[#5c6f60] text-sm w-44 font-semibold shrink-0">{{ $label }}</span>
                                        <span class="text-[#133827] text-sm font-bold">{{ $val }}</span>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <!-- Penjelasan Narasi AI -->
                    <div class="space-y-2 pt-2">
                        <h4 class="text-sm font-bold text-[#1b4332]">Alasan Menggunakan Tanda / Kaidah:</h4>
                        <div class="bg-[#fcfbfa] p-4 rounded-xl text-[#2b3a32] text-sm leading-relaxed border border-[#e6dec9]">
                            {{ $item['explanation'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Rujukan Materi Kitab Jurumiyah di Bawahnya -->
        <div class="kitab-box rounded-xl p-6 space-y-4">
            <h3 class="text-lg font-bold text-[#1b4332] flex items-center space-x-2">
                <i class="fa-solid fa-book-open"></i>
                <span>Materi Rujukan Jurumiyah</span>
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($relatedChapters as $chapter)
                    <div x-data="{ open: false }" class="p-4 bg-[#fcfbfa] rounded-2xl border border-[#e6dec9] hover:border-[#1b4332] transition duration-300">
                        <div @click="open = !open" class="cursor-pointer flex justify-between items-start gap-4">
                            <div>
                                <h4 class="font-bold text-sm text-[#133827]">{{ $chapter->title }}</h4>
                                <p class="text-xs text-[#5c6f60] mt-1">{{ $chapter->definition }}</p>
                            </div>
                            <span class="text-[#b45309] text-xs font-bold transition-transform duration-200 mt-1 shrink-0" :class="open ? 'rotate-180' : ''">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        @if($chapter->grammarRules && $chapter->grammarRules->count() > 0)
                            <div x-show="open" x-collapse x-transition class="border-t border-[#e6dec9] pt-3 mt-3 space-y-1.5">
                                <span class="text-[10px] font-bold text-[#b45309] uppercase tracking-wider block">Isi Kaidah:</span>
                                <ul class="list-disc list-inside text-xs text-[#2b3a32] space-y-1">
                                    @foreach($chapter->grammarRules as $rule)
                                        <li>{{ $rule->rule_text }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-6 text-sm text-[#5c6f60] col-span-full">
                        Tidak ada materi rujukan yang langsung terikat.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
