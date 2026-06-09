@extends('layouts.admin')

@section('title', 'Log Percobaan Kuis - Admin Smart Nahwu')

@section('content')
<div class="max-w-6xl mx-auto space-y-6" x-data="{ openDetail: false, activeItem: null, activeStudent: '', activeTitle: '', activeScore: 0 }">
    <!-- Header -->
    <div class="space-y-1">
        <h1 class="text-3xl font-extrabold text-[#1b4332]">Log Percobaan Kuis</h1>
        <p class="text-sm text-[#5c6f60]">Pemantauan aktivitas kuis dan nilai yang diperoleh siswa secara real-time.</p>
    </div>

    <!-- Table Card -->
    <div class="glass bg-white rounded-3xl overflow-hidden shadow-sm border border-[#e6dec9]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcfbfa] border-b border-[#e6dec9] text-[#4a5d4e] text-xs uppercase tracking-wider font-bold">
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Nama Kuis</th>
                        <th class="px-6 py-4">Skor</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e6dec9] text-[#2b3a32] text-sm">
                    @forelse($quizzes as $attempt)
                        <tr class="hover:bg-[#fbf8f1]/40 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#1b4332]">{{ $attempt->user->name }}</span>
                                <span class="block text-[10px] text-[#5c6f60]">{{ $attempt->user->email }}</span>
                            </td>
                            <td class="px-6 py-4 font-semibold">{{ $attempt->kuis->judul }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $badgeColor = $attempt->skor >= 70 ? 'text-[#385723] bg-[#e2f0d9]' : 'text-[#c65911] bg-[#fce4d6]';
                                @endphp
                                <span class="text-xs font-extrabold px-2.5 py-1 rounded-lg {{ $badgeColor }}">
                                    {{ number_format($attempt->skor, 0) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-[#5c6f60]">{{ $attempt->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-center">
                                <button 
                                    @click="activeItem = {{ json_encode($attempt->data_jawaban) }}; activeStudent = '{{ $attempt->user->name }}'; activeTitle = '{{ $attempt->kuis->judul }}'; activeScore = {{ $attempt->skor }}; openDetail = true"
                                    class="px-3 py-1.5 bg-[#1b4332]/10 hover:bg-[#1b4332] text-[#1b4332] hover:text-white border border-[#1b4332]/25 rounded-lg text-xs font-bold transition cursor-pointer"
                                >
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-[#5c6f60]">Belum ada aktivitas kuis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($quizzes->hasPages())
            <div class="px-6 py-4 bg-[#fcfbfa] border-t border-[#e6dec9]">
                {{ $quizzes->links() }}
            </div>
        @endif
    </div>

    <!-- AlpineJS Modal Detail Jawaban Kuis -->
    <div 
        class="fixed inset-0 z-50 overflow-y-auto" 
        x-show="openDetail" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
    >
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openDetail = false"></div>

        <!-- Content Box -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div 
                class="relative w-full max-w-3xl bg-[#fbf8f1] rounded-3xl border border-[#e6dec9] shadow-2xl overflow-hidden flex flex-col max-h-[85vh]"
                x-show="openDetail"
                x-transition:enter="transition ease-out duration-300 transform scale-95"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform scale-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <!-- Header -->
                <div class="bg-[#1b4332] text-white p-6 flex justify-between items-center border-b border-[#dfb15b]/20">
                    <div>
                        <h3 class="text-lg font-bold">Rincian Lembar Jawaban Kuis</h3>
                        <p class="text-xs text-[#dfb15b]" x-text="activeStudent + ' • ' + activeTitle"></p>
                    </div>
                    <button @click="openDetail = false" class="text-white/80 hover:text-white transition">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- Body (Scrollable) -->
                <div class="p-6 overflow-y-auto space-y-6 flex-1">
                    <!-- Score Overview -->
                    <div class="bg-white p-6 rounded-2xl border border-[#e6dec9] flex items-center gap-6 shadow-sm">
                        <div 
                            class="w-20 h-20 rounded-full border-4 flex flex-col items-center justify-center shrink-0"
                            :class="activeScore >= 70 ? 'border-emerald-600 text-emerald-700 bg-emerald-50' : 'border-rose-600 text-rose-700 bg-rose-50'"
                        >
                            <span class="text-2xl font-extrabold" x-text="activeScore"></span>
                            <span class="text-[8px] font-bold uppercase tracking-wider">Skor</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-base text-[#133827]" x-text="activeScore >= 70 ? 'Lulus Evaluasi' : 'Belum Lulus Evaluasi'"></h4>
                            <p class="text-xs text-[#5c6f60]" x-text="activeScore >= 70 ? 'Siswa menguasai bab ini dengan baik.' : 'Siswa disarankan membaca kembali rujukan bab.'"></p>
                        </div>
                    </div>

                    <!-- Answers Review -->
                    <div class="space-y-4">
                        <h4 class="font-bold text-sm text-[#1b4332]">Ulasan Jawaban & Pembahasan:</h4>
                        
                        <template x-if="activeItem">
                            <div class="space-y-4">
                                <template x-for="(answer, idx) in activeItem">
                                    <div 
                                        class="p-5 rounded-2xl border flex flex-col gap-3 bg-white"
                                        :class="answer.is_correct ? 'border-emerald-600/30' : 'border-rose-600/30'"
                                    >
                                        <!-- Header Soal -->
                                        <div class="flex items-start space-x-2">
                                            <div class="shrink-0 mt-0.5">
                                                <template x-if="answer.is_correct">
                                                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                                                </template>
                                                <template x-if="!answer.is_correct">
                                                    <i class="fa-solid fa-circle-xmark text-rose-600 text-base"></i>
                                                </template>
                                            </div>
                                            <div class="space-y-0.5">
                                                <span class="text-[8px] font-bold text-[#5c6f60] uppercase block" x-text="'SOAL ' + (idx + 1)"></span>
                                                <div class="text-xs font-bold text-[#133827] leading-relaxed" x-text="answer.question_text"></div>
                                            </div>
                                        </div>

                                        <!-- Detail Jawaban -->
                                        <div class="grid grid-cols-2 gap-3 text-[11px]">
                                            <div class="p-2.5 bg-[#fcfbfa] rounded-lg border border-[#e6dec9]">
                                                <span class="text-[#5c6f60] block font-semibold mb-0.5">Jawaban Siswa</span>
                                                <span class="font-bold text-[#2b3a32]" x-text="'Opsi ' + (answer.user_selected || '(Kosong)')"></span>
                                            </div>
                                            <div class="p-2.5 bg-[#fcfbfa] rounded-lg border border-[#e6dec9]">
                                                <span class="text-emerald-700 block font-semibold mb-0.5">Kunci Jawaban</span>
                                                <span class="font-bold text-emerald-800" x-text="'Opsi ' + answer.correct_answer"></span>
                                            </div>
                                        </div>

                                        <!-- Pembahasan -->
                                        <div class="space-y-1">
                                            <span class="text-[9px] font-bold text-[#5c6f60] uppercase block">Pembahasan Teoritis</span>
                                            <div class="p-3 bg-[#fcfbfa] rounded-lg text-xs text-[#2b3a32] leading-relaxed border border-[#e6dec9]" x-text="answer.explanation"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-[#fcfbfa] p-4 border-t border-[#e6dec9] flex justify-end">
                    <button @click="openDetail = false" class="px-4 py-2 bg-white hover:bg-gray-100 border border-gray-300 rounded-xl text-xs font-bold transition cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

