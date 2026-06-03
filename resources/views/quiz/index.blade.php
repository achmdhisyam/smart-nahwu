@extends('layouts.app')

@section('title', 'Alur Belajar & Latihan Kuis - Smart Nahwu')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    
    <!-- Top Progress Widget & Recommendation -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Progress Bar Card -->
        <div class="kitab-box p-6 rounded-xl space-y-4 md:col-span-2">
            <div class="flex justify-between items-center text-sm font-semibold text-[#1b4332]">
                <span>Kemajuan Penguasaan Jurumiyah</span>
                <span class="text-[#b45309] font-bold text-lg">{{ $stats['percentage'] }}%</span>
            </div>
            
            <!-- Progress Bar -->
            <div class="w-full bg-[#fcfbfa] rounded-full h-3.5 border border-[#e6dec9] overflow-hidden">
                <div class="bg-[#1b4332] h-full rounded-full transition-all duration-500" style="width: {{ $stats['percentage'] }}%"></div>
            </div>
            
            <p class="text-xs text-[#5c6f60]">
                Anda telah menguasai secara mendalam <span class="text-[#133827] font-bold">{{ $stats['completed'] }} dari {{ $stats['total'] }} Bab</span> (Kriteria Mastered: skor kuis >= 80).
            </p>
        </div>

        <!-- Learning Recommendation Card -->
        <div class="kitab-box p-6 rounded-xl space-y-3 relative overflow-hidden flex flex-col justify-between">
            <div class="space-y-1">
                <span class="text-[10px] uppercase font-bold text-[#b45309] tracking-wider block">Saran Belajar Hari Ini</span>
                @if($recommendation)
                    <h3 class="font-bold text-[#133827] text-sm leading-snug">Bab {{ $recommendation->learning_step }}: {{ $recommendation->title }}</h3>
                    <p class="text-xs text-[#5c6f60] line-clamp-2">{{ $recommendation->definition }}</p>
                @else
                    <h3 class="font-bold text-[#133827] text-sm leading-snug">Selamat!</h3>
                    <p class="text-xs text-[#5c6f60]">Anda telah berhasil menamatkan seluruh rangkaian materi kuis Kitab Jurumiyah!</p>
                @endif
            </div>

            @if($recommendation)
                <div class="pt-2">
                    <a href="{{ route('quiz.show', $recommendation->id) }}" class="w-full text-center inline-block bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-2 rounded-lg text-xs transition border border-[#1b4332]">
                        Mulai Pelajari
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Grid: Chapters Path & Achievements -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Alur Belajar Terstruktur (Learning Steps) -->
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-lg font-bold text-[#1b4332]">Learning Path Jurumiyah</h2>
            
            @forelse($chapters as $chapter)
                @php
                    $isMastered = $chapter->progress_status === 'mastered';
                    $isLearning = $chapter->progress_status === 'learning';
                    
                    $borderClass = $isMastered 
                        ? 'border-emerald-600/30 bg-emerald-50/40' 
                        : ($isLearning ? 'border-[#1b4332]/30 bg-[#1b4332]/5' : 'border-[#e6dec9] bg-white');
                    
                    $statusIcon = $isMastered
                        ? '<span class="text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded text-[10px] font-bold border border-emerald-200">✓ Mastered</span>'
                        : ($isLearning ? '<span class="text-[#b45309] bg-[#fff2cc] px-2 py-0.5 rounded text-[10px] font-bold border border-[#ffe599]">✎ Dipelajari</span>' : '<span class="text-[#7f7f7f] bg-gray-100 px-2 py-0.5 rounded text-[10px] font-bold border border-gray-200">🔒 Terkunci</span>');
                @endphp
                <div class="kitab-box p-5 rounded-xl transition duration-300 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 {{ $borderClass }}">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2 text-[10px] font-bold text-[#5c6f60] uppercase tracking-wider">
                            <span>Langkah {{ $chapter->learning_step }}</span>
                            <span>•</span>
                            <span>Bab {{ $chapter->order_num }}</span>
                            <span>•</span>
                            {!! $statusIcon !!}
                        </div>
                        <h3 class="font-bold text-[#133827] text-base mt-1">{{ $chapter->title }}</h3>
                        <p class="text-xs text-[#5c6f60] line-clamp-2 leading-relaxed">{{ $chapter->definition }}</p>
                        
                        @if($chapter->best_score !== null)
                            <div class="text-[10px] text-[#5c6f60] font-medium pt-1">
                                Skor Terbaik: <span class="font-bold text-[#b45309]">{{ number_format($chapter->best_score, 0) }}%</span> | Percobaan: {{ $chapter->attempts }}x
                            </div>
                        @endif
                    </div>

                    <div class="w-full sm:w-auto shrink-0">
                        <a 
                            href="{{ route('quiz.show', $chapter->id) }}" 
                            class="w-full sm:w-auto text-center inline-block px-4 py-2 bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold rounded-lg text-xs transition border border-[#1b4332]"
                        >
                            {{ $chapter->best_score !== null ? 'Ulangi Kuis' : 'Mulai Kuis' }}
                        </a>
                    </div>
                </div>
            @empty
                <div class="kitab-box p-8 text-center text-sm text-[#5c6f60] rounded-xl">
                    Belum ada materi Jurumiyah yang diimpor.
                </div>
            @endforelse
        </div>

        <!-- Kolom Kanan: Achievements Lencana & Attempts Log -->
        <div class="space-y-6">
            <!-- Lencana Pencapaian (Achievements) -->
            <div class="space-y-3">
                <h2 class="text-lg font-bold text-[#1b4332]">Lencana Pencapaian Anda</h2>
                <div class="kitab-box p-5 rounded-xl space-y-4">
                    @forelse($achievements as $ach)
                        <div class="flex items-center space-x-3 p-3 bg-[#fcfbfa] border border-[#e6dec9] rounded-xl">
                            <div class="text-[#b45309] text-xl p-2 bg-[#fff2cc] rounded-lg shrink-0 border border-[#ffe599]">
                                <i class="fa-solid fa-trophy"></i>
                            </div>
                            <div class="space-y-0.5">
                                <h4 class="font-bold text-xs text-[#133827]">{{ $ach->title }}</h4>
                                <p class="text-[10px] text-[#5c6f60] leading-normal">{{ $ach->description }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-[#5c6f60] leading-normal">
                            Anda belum memperoleh lencana pencapaian apa pun. Selesaikan kuis dengan nilai tinggi untuk memicu lencana!
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Riwayat Nilai Terbaru -->
            <div class="space-y-3">
                <h2 class="text-lg font-bold text-[#1b4332]">Ujian Terbaru</h2>
                <div class="kitab-box p-5 rounded-xl space-y-4">
                    @forelse($attempts as $attempt)
                        <div class="pb-3 border-b border-[#e6dec9]/60 last:border-b-0 last:pb-0 flex justify-between items-center gap-2 text-sm">
                            <div class="space-y-1">
                                <h4 class="font-bold text-[#133827] text-xs truncate max-w-[180px]">{{ $attempt->quiz->title }}</h4>
                                <span class="text-[10px] text-[#5c6f60] block">{{ $attempt->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                @php
                                    $badgeColor = $attempt->score >= 70 ? 'text-emerald-700 bg-emerald-50 border border-emerald-200' : 'text-rose-700 bg-rose-50 border border-rose-200';
                                @endphp
                                <span class="text-xs font-bold px-2 py-0.5 rounded {{ $badgeColor }}">
                                    {{ number_format($attempt->score, 0) }}
                                </span>
                                <a href="{{ route('quiz.result', $attempt->id) }}" class="text-xs text-[#b45309] hover:underline font-bold">Detail</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-[#5c6f60]">
                            Belum ada riwayat pengerjaan kuis.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
