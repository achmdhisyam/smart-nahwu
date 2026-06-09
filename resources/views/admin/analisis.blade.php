@extends('layouts.admin')

@section('title', 'Log Analisis - Admin Smart Nahwu')

@section('content')
<div class="max-w-6xl mx-auto space-y-6" x-data="{ openDetail: false, activeItem: null }">
    <!-- Header -->
    <div class="space-y-1">
        <h1 class="text-3xl font-extrabold text-[#1b4332]">Log Riwayat Analisis</h1>
        <p class="text-sm text-[#5c6f60]">Pemantauan aktivitas analisis kalimat Arab oleh pengguna secara real-time.</p>
    </div>

    <!-- Table Card -->
    <div class="glass bg-white rounded-3xl overflow-hidden shadow-sm border border-[#e6dec9]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcfbfa] border-b border-[#e6dec9] text-[#4a5d4e] text-xs uppercase tracking-wider font-bold">
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Kalimat Arab</th>
                        <th class="px-6 py-4">Struktur</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e6dec9] text-[#2b3a32] text-sm">
                    @forelse($analyses as $analysis)
                        <tr class="hover:bg-[#fbf8f1]/40 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#1b4332]">{{ $analysis->user->name ?? 'Guest/Tamu' }}</span>
                                <span class="block text-[10px] text-[#5c6f60]">{{ $analysis->user->email ?? 'Tamu/Public' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-2xl font-arabic text-[#133827] dir-rtl text-right" dir="rtl">
                                    {{ $analysis->input_text }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold">
                                <span class="px-2.5 py-1 bg-[#1b4332]/10 border border-[#1b4332]/20 text-[#1b4332] rounded-lg">
                                    {{ $analysis->hasil_analisis['sentence_structure'] ?? 'Jumlah Ismiyah' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-[#5c6f60]">{{ $analysis->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-center">
                                <button 
                                    @click="activeItem = {{ json_encode($analysis->hasil_analisis) }}; openDetail = true"
                                    class="px-3 py-1.5 bg-[#1b4332]/10 hover:bg-[#1b4332] text-[#1b4332] hover:text-white border border-[#1b4332]/25 rounded-lg text-xs font-bold transition cursor-pointer"
                                >
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-[#5c6f60]">Belum ada aktivitas analisis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($analyses->hasPages())
            <div class="px-6 py-4 bg-[#fcfbfa] border-t border-[#e6dec9]">
                {{ $analyses->links() }}
            </div>
        @endif
    </div>

    <!-- AlpineJS Modal Detail Analisis -->
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
                class="relative w-full max-w-4xl bg-[#fbf8f1] rounded-3xl border border-[#e6dec9] shadow-2xl overflow-hidden flex flex-col max-h-[85vh]"
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
                        <h3 class="text-lg font-bold">Rincian Hasil Analisis AI</h3>
                        <p class="text-xs text-[#dfb15b]" x-text="'Struktur: ' + (activeItem ? activeItem.sentence_structure : '-')"></p>
                    </div>
                    <button @click="openDetail = false" class="text-white/80 hover:text-white transition">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- Body (Scrollable) -->
                <div class="p-6 overflow-y-auto space-y-6 flex-1">
                    <!-- Vocalized Complete -->
                    <template x-if="activeItem && activeItem.vocalized_sentence">
                        <div class="bg-white p-5 rounded-2xl border border-[#e6dec9] text-center space-y-1">
                            <span class="text-[10px] font-bold text-[#b45309] uppercase tracking-wider block">Kalimat Lengkap Berharakat</span>
                            <p class="text-3xl font-arabic text-[#133827] leading-relaxed" dir="rtl" x-text="activeItem.vocalized_sentence"></p>
                        </div>
                    </template>

                    <!-- Table Word by Word -->
                    <div class="space-y-3">
                        <h4 class="font-bold text-sm text-[#1b4332]">Analisis Per Kata:</h4>
                        <div class="overflow-x-auto border border-[#e6dec9] rounded-2xl bg-white">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-[#fcfbfa] border-b border-[#e6dec9] text-[#4a5d4e] font-bold uppercase">
                                        <th class="px-4 py-3 text-right">Kata</th>
                                        <th class="px-4 py-3">Jenis Kata</th>
                                        <th class="px-4 py-3">Status I'rab</th>
                                        <th class="px-4 py-3">Tanda I'rab</th>
                                        <th class="px-4 py-3">Kedudukan</th>
                                        <th class="px-4 py-3">Alasan / Penjelasan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e6dec9]">
                                    <template x-if="activeItem">
                                        <template x-for="word in activeItem.word_by_word_analysis">
                                            <tr class="hover:bg-[#fbf8f1]/50 transition">
                                                <td class="px-4 py-3 font-arabic text-right text-xl text-[#133827]" dir="rtl" x-text="word.vocalized_word || word.word"></td>
                                                <td class="px-4 py-3 font-bold text-[#1b4332]" x-text="word.part_of_speech"></td>
                                                <td class="px-4 py-3">
                                                    <span 
                                                        class="px-2 py-0.5 rounded font-bold uppercase text-[9px] border"
                                                        :class="{
                                                            'bg-[#e2f0d9] text-[#385723] border-[#c5e0b4]': (word.irab_status || '').toLowerCase().includes('rafa'),
                                                            'bg-[#fce4d6] text-[#c65911] border-[#f8cbad]': (word.irab_status || '').toLowerCase().includes('nashab'),
                                                            'bg-[#fff2cc] text-[#7f6000] border-[#ffe599]': (word.irab_status || '').toLowerCase().includes('jar') || (word.irab_status || '').toLowerCase().includes('khafadh'),
                                                            'bg-[#ededed] text-[#595959] border-[#d9d9d9]': (word.irab_status || '').toLowerCase().includes('jazm'),
                                                            'bg-gray-100 text-gray-500 border-gray-200': !(word.irab_status || '').toLowerCase().includes('rafa') && !(word.irab_status || '').toLowerCase().includes('nashab') && !(word.irab_status || '').toLowerCase().includes('jar') && !(word.irab_status || '').toLowerCase().includes('khafadh') && !(word.irab_status || '').toLowerCase().includes('jazm')
                                                        }"
                                                        x-text="word.irab_status"
                                                    ></span>
                                                </td>
                                                <td class="px-4 py-3 text-[#5c6f60]" x-text="word.irab_marker || '-'"></td>
                                                <td class="px-4 py-3 font-semibold text-[#1b4332]" x-text="word.syntactic_role || '-'"></td>
                                                <td class="px-4 py-3 text-[#5c6f60] max-w-xs leading-relaxed" x-text="word.explanation"></td>
                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>
                        </div>
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

