@extends('layouts.app')

@section('title', 'Hasil Evaluasi Kuis - Smart Nahwu')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <!-- Header/Back Navigation -->
    <div>
        <a href="{{ route('kuis.index') }}" class="text-sm font-semibold text-[#1b4332] hover:text-[#b45309] flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Menu Kuis</span>
        </a>
    </div>

    <!-- Score Card Overview -->
    @php
        $passed = $attempt->skor >= 70;
        $scoreRingColor = $passed ? 'border-emerald-600 text-emerald-700 bg-emerald-50' : 'border-rose-600 text-rose-700 bg-rose-50';
        $statusText = $passed ? 'Selamat, Anda Lulus!' : 'Butuh Latihan Lagi!';
        $statusDesc = $passed 
            ? 'Pemahaman Anda mengenai materi ini sudah cukup matang secara kaidah.' 
            : 'Silakan baca kembali bab penjelas dan ulangi kuis untuk hasil lebih baik.';
    @endphp
    
    <div class="kitab-box p-8 rounded-xl flex flex-col sm:flex-row items-center gap-8 shadow-md">
        <!-- Score Circular Badge -->
        <div class="w-32 h-32 rounded-full border-4 flex flex-col items-center justify-center space-y-1 shrink-0 {{ $scoreRingColor }}">
            <span class="text-4xl font-extrabold">{{ number_format($attempt->skor, 0) }}</span>
            <span class="text-[10px] font-bold uppercase tracking-wider">Skor Ujian</span>
        </div>

        <!-- Status Details -->
        <div class="text-center sm:text-left space-y-2">
            <h2 class="text-2xl font-extrabold text-[#133827]">{{ $statusText }}</h2>
            <p class="text-sm text-[#2b3a32] leading-relaxed">{{ $statusDesc }}</p>
            <div class="pt-2 text-xs text-[#5c6f60]">
                Kuis: {{ $attempt->kuis->judul }} | Tanggal: {{ $attempt->created_at->format('d M Y - H:i') }}
            </div>
        </div>
    </div>

    <!-- Review Section -->
    <div class="space-y-6">
        <h3 class="text-xl font-bold text-[#1b4332]">Ulasan Pembahasan Soal</h3>

        @foreach($attempt->data_jawaban as $index => $answer)
            @php
                $cardBorder = $answer['is_correct'] ? 'border-emerald-600/30 bg-emerald-50/20' : 'border-rose-600/30 bg-rose-50/20';
                $statusIcon = $answer['is_correct'] 
                    ? '<i class="fa-solid fa-circle-check text-emerald-600 text-xl shrink-0 mt-0.5"></i>' 
                    : '<i class="fa-solid fa-circle-xmark text-rose-600 text-xl shrink-0 mt-0.5"></i>';
            @endphp
            <div class="kitab-box p-6 rounded-xl space-y-4 {{ $cardBorder }}">
                <!-- Header Soal -->
                <div class="flex items-start space-x-3">
                    {!! $statusIcon !!}
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-[#5c6f60] uppercase">SOAL {{ $index + 1 }}</span>
                        <div class="text-sm font-bold text-[#133827] leading-relaxed">{{ $answer['question_text'] }}</div>
                    </div>
                </div>

                <!-- Hasil Jawaban Pembanding -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-semibold">
                    <div class="p-3 bg-white rounded-lg border border-[#e6dec9]">
                        <span class="text-[#5c6f60] block mb-1">Jawaban Anda</span>
                        <span class="font-bold text-[#2b3a32] text-sm block">
                            Opsi {{ $answer['user_selected'] ?? '(Tidak Menjawab)' }}
                        </span>
                    </div>
                    <div class="p-3 bg-white rounded-lg border border-[#e6dec9]">
                        <span class="text-emerald-700 block mb-1">Kunci Jawaban Benar</span>
                        <span class="font-bold text-emerald-800 text-sm block">
                            Opsi {{ $answer['correct_answer'] }}
                        </span>
                    </div>
                </div>

                <!-- Pembahasan/Explanation -->
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-[#5c6f60] uppercase block">Pembahasan Teoritis</span>
                    <div class="p-4 bg-[#fcfbfa] rounded-lg text-xs text-[#2b3a32] leading-relaxed border border-[#e6dec9]">
                        {{ $answer['explanation'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
