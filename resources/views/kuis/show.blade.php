@extends('layouts.app')

@section('title', $quiz->judul . ' - Smart Nahwu')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{ currentStep: 0, totalSteps: {{ count($quiz->data_pertanyaan['questions']) }}, answers: {} }">
    <!-- Breadcrumb -->
    <div>
        <a href="{{ route('kuis.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#fcfbfa] hover:bg-[#f5f2eb] text-[#1b4332] text-xs font-bold rounded-xl border border-[#e6dec9] transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Batal & Kembali</span>
        </a>
    </div>

    <!-- Quiz Card Header -->
    <div class="kitab-box p-6 rounded-xl space-y-3">
        <div class="flex justify-between items-center">
            <span class="text-xs font-bold px-2.5 py-0.5 bg-[#1b4332]/10 border border-[#1b4332]/20 text-[#1b4332] rounded-full">
                Kategori: {{ $chapter->judul }}
            </span>
            <span class="text-xs font-bold text-[#1b4332]" x-text="`Progres: ${Math.round(((currentStep + 1) / totalSteps) * 100)}%`"></span>
        </div>
        <h1 class="text-2xl font-bold text-[#133827]">{{ $quiz->judul }}</h1>
        <p class="text-xs text-[#5c6f60]">Jawablah pertanyaan-pertanyaan berikut secara jujur untuk menguji keterampilan tata bahasa Anda.</p>
        
        <!-- Progress Bar -->
        <div class="w-full bg-[#e6dec9]/40 h-2 rounded-full overflow-hidden relative mt-2">
            <div class="bg-gradient-to-r from-[#1b4332] to-[#2d5a45] h-full transition-all duration-500 ease-out" :style="`width: ${((currentStep + 1) / totalSteps) * 100}%`"></div>
        </div>
    </div>

    <!-- Form Lembar Ujian -->
    <form action="{{ route('kuis.submit', $quiz->id) }}" method="POST" class="space-y-6">
        @csrf

        @foreach($quiz->data_pertanyaan['questions'] as $index => $q)
            <div 
                x-show="currentStep === {{ $index }}" 
                x-data="{ selectedOption: '' }"
                x-init="$watch('selectedOption', value => {
                    answers[{{ $index }}] = value;
                    if (value !== '') {
                        setTimeout(() => {
                            if (currentStep < totalSteps - 1) {
                                currentStep++;
                            }
                        }, 2200);
                    }
                })"
                class="kitab-box p-6 sm:p-8 rounded-xl space-y-6 shadow-md"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <!-- Hidden input to ensure value is submitted even when radio is disabled -->
                <input type="hidden" name="answers[{{ $q['id'] }}]" :value="selectedOption">

                <!-- Indikator Pertanyaan -->
                <div class="flex justify-between items-center pb-3 border-b border-[#e6dec9]">
                    <span class="text-xs font-bold text-[#5c6f60] uppercase">PERTANYAAN {{ $index + 1 }} DARI {{ count($quiz->data_pertanyaan['questions']) }}</span>
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
                            :class="{
                                'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500 opacity-100': (selectedOption === '{{ $option['id'] }}' && selectedOption === '{{ $q['correct_answer'] ?? '' }}') || (selectedOption !== '' && '{{ $option['id'] }}' === '{{ $q['correct_answer'] ?? '' }}'),
                                'border-rose-500 bg-rose-50 ring-1 ring-rose-500 opacity-100': selectedOption === '{{ $option['id'] }}' && selectedOption !== '{{ $q['correct_answer'] ?? '' }}',
                                'border-[#e6dec9] bg-white hover:bg-[#fcfbfa] border opacity-100': selectedOption === '',
                                'border-[#e6dec9]/40 bg-white/40 border opacity-40 pointer-events-none': selectedOption !== '' && selectedOption !== '{{ $option['id'] }}' && '{{ $option['id'] }}' !== '{{ $q['correct_answer'] ?? '' }}',
                                'pointer-events-none': selectedOption !== ''
                            }"
                            class="flex items-center space-x-3 p-4 rounded-xl cursor-pointer transition duration-200 relative overflow-hidden"
                        >
                            <input 
                                type="radio" 
                                name="radio_{{ $q['id'] }}" 
                                value="{{ $option['id'] }}" 
                                x-model="selectedOption"
                                :disabled="selectedOption !== ''"
                                class="h-4 w-4 text-[#1b4332] focus:ring-[#1b4332] border-[#e6dec9] bg-[#fcfbfa]"
                            />
                            <span 
                                :class="{
                                    'bg-emerald-600 text-white border-emerald-700': (selectedOption === '{{ $option['id'] }}' && selectedOption === '{{ $q['correct_answer'] ?? '' }}') || (selectedOption !== '' && '{{ $option['id'] }}' === '{{ $q['correct_answer'] ?? '' }}'),
                                    'bg-rose-600 text-white border-rose-700': selectedOption === '{{ $option['id'] }}' && selectedOption !== '{{ $q['correct_answer'] ?? '' }}',
                                    'bg-[#fff2cc] text-[#b45309] border-[#ffe599]': selectedOption === '' || (selectedOption !== '{{ $option['id'] }}' && '{{ $option['id'] }}' !== '{{ $q['correct_answer'] ?? '' }}')
                                }"
                                class="text-xs font-bold px-2 py-0.5 rounded-md border"
                            >
                                {{ $option['id'] }}
                            </span>
                            <span class="text-sm text-[#2b3a32] font-semibold flex-1">{{ $option['text'] }}</span>

                            <!-- Ikon Visual Feedback -->
                            <div x-show="(selectedOption === '{{ $option['id'] }}' && selectedOption === '{{ $q['correct_answer'] ?? '' }}') || (selectedOption !== '' && '{{ $option['id'] }}' === '{{ $q['correct_answer'] ?? '' }}')" class="absolute right-4 text-emerald-500 text-xl" style="display: none;">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div x-show="selectedOption === '{{ $option['id'] }}' && selectedOption !== '{{ $q['correct_answer'] ?? '' }}'" class="absolute right-4 text-rose-500 text-xl" style="display: none;">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                        </label>
                    @endforeach
                </div>

                <!-- Feedback Card -->
                <div 
                    x-show="selectedOption !== ''"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    :class="selectedOption === '{{ $q['correct_answer'] ?? '' }}' ? 'bg-emerald-50 border-emerald-200 text-emerald-900' : 'bg-rose-50 border-rose-200 text-rose-900'"
                    class="p-4 rounded-xl border flex items-center gap-3 text-sm font-bold shadow-inner"
                    style="display: none;"
                >
                    <template x-if="selectedOption === '{{ $q['correct_answer'] ?? '' }}'">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                            <span>Luar Biasa! Jawaban Anda Benar.</span>
                        </div>
                    </template>
                    <template x-if="selectedOption !== '' && selectedOption !== '{{ $q['correct_answer'] ?? '' }}'">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-xmark text-rose-600 text-lg"></i>
                            <span>Jawaban Kurang Tepat. Jawaban yang benar adalah Opsi {{ $q['correct_answer'] ?? '' }}.</span>
                        </div>
                    </template>
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
                :disabled="!answers[currentStep]"
                :class="!answers[currentStep] ? 'opacity-50 cursor-not-allowed' : ''"
                class="px-5 py-2.5 bg-[#1b4332] hover:bg-[#2d5a45] text-white rounded-xl text-sm font-bold transition border border-[#1b4332]"
            >
                Selanjutnya
            </button>

            <!-- Tombol Submit -->
            <button 
                type="submit" 
                x-show="currentStep === totalSteps - 1"
                :disabled="!answers[currentStep]"
                :class="!answers[currentStep] ? 'opacity-50 cursor-not-allowed' : ''"
                class="px-6 py-2.5 bg-[#b45309] hover:bg-[#9a4004] text-white rounded-xl text-sm font-bold transition border border-[#b45309]"
            >
                Kirim Jawaban
            </button>
        </div>
    </form>
</div>
@endsection
