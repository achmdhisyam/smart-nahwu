@extends('layouts.app')

@section('title', $quiz->title . ' - Smart Nahwu')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{ currentStep: 0, totalSteps: {{ count($quiz->questions_data['questions']) }} }">
    <!-- Breadcrumb -->
    <div>
        <a href="{{ route('quiz.index') }}" class="text-sm font-semibold text-[#1b4332] hover:text-[#b45309] flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Batal & Kembali</span>
        </a>
    </div>

    <!-- Quiz Card Header -->
    <div class="kitab-box p-6 rounded-xl space-y-2">
        <span class="text-xs font-bold px-2.5 py-0.5 bg-[#1b4332]/10 border border-[#1b4332]/20 text-[#1b4332] rounded-full">
            Kategori: {{ $chapter->title }}
        </span>
        <h1 class="text-2xl font-bold text-[#133827]">{{ $quiz->title }}</h1>
        <p class="text-xs text-[#5c6f60]">Jawablah pertanyaan-pertanyaan berikut secara jujur untuk menguji keterampilan tata bahasa Anda.</p>
    </div>

    <!-- Form Lembar Ujian -->
    <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST" class="space-y-6">
        @csrf

        @foreach($quiz->questions_data['questions'] as $index => $q)
            <div 
                x-show="currentStep === {{ $index }}" 
                class="kitab-box p-6 sm:p-8 rounded-xl space-y-6 shadow-md"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <!-- Indikator Pertanyaan -->
                <div class="flex justify-between items-center pb-3 border-b border-[#e6dec9]">
                    <span class="text-xs font-bold text-[#5c6f60] uppercase">PERTANYAAN {{ $index + 1 }} DARI {{ count($quiz->questions_data['questions']) }}</span>
                    <span class="text-xs text-[#b45309] bg-[#fff2cc] px-2.5 py-0.5 rounded border border-[#ffe599]">Pilihan Ganda</span>
                </div>

                <!-- Teks Soal -->
                <div class="text-lg font-bold text-[#133827] leading-relaxed">
                    {{ $q['question'] }}
                </div>

                <!-- Pilihan Jawaban -->
                <div class="grid grid-cols-1 gap-3">
                    @foreach($q['options'] as $option)
                        <label 
                            class="flex items-center space-x-3 p-4 bg-white hover:bg-[#fcfbfa] border border-[#e6dec9] hover:border-[#1b4332]/40 rounded-xl cursor-pointer transition duration-150"
                        >
                            <input 
                                type="radio" 
                                name="answers[{{ $q['id'] }}]" 
                                value="{{ $option['id'] }}" 
                                required
                                class="h-4 w-4 text-[#1b4332] focus:ring-[#1b4332] border-[#e6dec9] bg-[#fcfbfa]"
                            />
                            <span class="text-xs font-bold text-[#b45309] px-2 py-0.5 bg-[#fff2cc] border border-[#ffe599] rounded-md">{{ $option['id'] }}</span>
                            <span class="text-sm text-[#2b3a32] font-semibold">{{ $option['text'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Tombol Navigasi Lembar Ujian -->
        <div class="flex justify-between items-center gap-4">
            <button 
                type="button" 
                @click="currentStep--" 
                x-show="currentStep > 0"
                class="px-5 py-2.5 bg-white hover:bg-[#fcfbfa] border border-[#e6dec9] text-[#5c6f60] rounded-xl text-sm font-bold transition shadow-sm"
            >
                Sebelumnya
            </button>
            <div x-show="currentStep === 0"></div> <!-- Placeholder -->

            <!-- Tombol Lanjut -->
            <button 
                type="button" 
                @click="currentStep++" 
                x-show="currentStep < totalSteps - 1"
                class="px-5 py-2.5 bg-[#1b4332] hover:bg-[#2d5a45] text-white rounded-xl text-sm font-bold transition border border-[#1b4332]"
            >
                Selanjutnya
            </button>

            <!-- Tombol Submit -->
            <button 
                type="submit" 
                x-show="currentStep === totalSteps - 1"
                class="px-6 py-2.5 bg-[#b45309] hover:bg-[#9a4004] text-white rounded-xl text-sm font-bold transition border border-[#b45309]"
            >
                Kirim Jawaban
            </button>
        </div>
    </form>
</div>
@endsection
