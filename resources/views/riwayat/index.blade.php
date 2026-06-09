@extends('layouts.app')

@section('title', 'Riwayat Analisis - Smart Nahwu')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1b4332]">Riwayat Analisis Anda</h1>
            <p class="text-sm text-[#5c6f60]">Daftar pencarian kalimat Arab yang pernah Anda analisis sebelumnya.</p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('riwayat.index') }}" method="GET" class="w-full sm:w-auto flex items-center space-x-2">
            <input 
                type="text" 
                name="search" 
                value="{{ $search }}"
                placeholder="Cari kalimat..." 
                class="w-full sm:w-64 bg-white border border-[#e6dec9] rounded-xl px-4 py-2.5 text-sm text-[#2b3a32] placeholder-[#a1b0a5] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] transition"
            />
            <button type="submit" class="bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold px-4 py-2.5 rounded-xl text-sm transition cursor-pointer border border-[#1b4332]">
                Cari
            </button>
            @if(!empty($search))
                <a href="{{ route('riwayat.index') }}" class="text-xs text-[#5c6f60] hover:text-[#1b4332] underline">Reset</a>
            @endif
        </form>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- History List Card -->
    <div class="glass bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#e6dec9]">
        @if($histories->isEmpty())
            <div class="text-center py-16 space-y-4">
                <div class="w-16 h-16 bg-[#1b4332]/10 border border-[#1b4332]/20 rounded-full flex items-center justify-center mx-auto text-[#1b4332]">
                    <i class="fa-solid fa-history text-2xl"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-[#1b4332]">Belum ada riwayat</h3>
                    <p class="text-sm text-[#5c6f60] max-w-xs mx-auto">Kalimat yang Anda analisis setelah login akan tersimpan otomatis di sini.</p>
                </div>
                <a href="/analisis" class="inline-block bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-2.5 px-6 rounded-xl text-sm transition border border-[#1b4332] shadow-sm">
                    Mulai Analisis Baru
                </a>
            </div>
        @else
            <!-- Desktop/Tablet List -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#e6dec9] text-[#4a5d4e] text-xs font-semibold uppercase tracking-wider">
                            <th class="py-4 px-2">Kalimat Arab</th>
                            <th class="py-4 px-2">Jenis Kalimat</th>
                            <th class="py-4 px-2">Tanggal Analisis</th>
                            <th class="py-4 px-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e6dec9]/60">
                        @foreach($histories as $history)
                            <tr class="hover:bg-[#fbf8f1]/40 transition duration-150">
                                <!-- Kalimat Arab -->
                                <td class="py-4 px-2 max-w-xs">
                                    <div class="text-2xl font-arabic text-[#133827] truncate dir-rtl" dir="rtl">
                                        {{ $history->input_text }}
                                    </div>
                                </td>
                                
                                <!-- Jenis Kalimat -->
                                <td class="py-4 px-2">
                                    <span class="px-2.5 py-0.5 text-xs font-bold bg-[#1b4332]/10 border border-[#1b4332]/20 text-[#1b4332] rounded-lg">
                                        {{ $history->hasil_analisis['sentence_structure'] ?? 'Jumlah Ismiyah' }}
                                    </span>
                                </td>

                                <!-- Tanggal -->
                                <td class="py-4 px-2 text-sm text-[#5c6f60]">
                                    {{ $history->created_at->diffForHumans() }}
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-2 text-right flex items-center justify-end space-x-2">
                                    <!-- Tombol Detail -->
                                    <a 
                                        href="{{ route('analisis.show', $history->id) }}" 
                                        class="px-3 py-1.5 bg-[#1b4332]/10 text-[#1b4332] border border-[#1b4332]/20 hover:bg-[#1b4332] hover:text-white rounded-lg text-xs font-bold transition flex items-center space-x-1"
                                    >
                                        <span>Lihat Detail</span>
                                        <i class="fa-solid fa-eye text-[10px]"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('riwayat.destroy', $history->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?');" class="m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="p-2 text-[#5c6f60] hover:text-rose-600 hover:bg-rose-500/10 border border-transparent hover:border-rose-500/20 rounded-lg transition cursor-pointer"
                                            title="Hapus"
                                        >
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginasi Laravel Tailwind -->
            <div class="pt-6 border-t border-[#e6dec9]">
                {{ $histories->appends(['search' => $search])->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
