@extends('layouts.app')

@section('title', 'Riwayat Analisis - Smart Nahwu')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-100">Riwayat Analisis Anda</h1>
            <p class="text-sm text-slate-400">Daftar pencarian kalimat Arab yang pernah Anda analisis sebelumnya.</p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('history.index') }}" method="GET" class="w-full sm:w-auto flex items-center space-x-2">
            <input 
                type="text" 
                name="search" 
                value="{{ $search }}"
                placeholder="Cari kalimat..." 
                class="w-full sm:w-64 bg-slate-900 border border-slate-700/50 rounded-xl px-4 py-2 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/50"
            />
            <button type="submit" class="bg-teal-500 hover:bg-teal-400 text-slate-900 font-bold px-4 py-2 rounded-xl text-sm transition">
                Cari
            </button>
            @if(!empty($search))
                <a href="{{ route('history.index') }}" class="text-xs text-slate-400 hover:text-slate-200 underline">Reset</a>
            @endif
        </form>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- History List Card -->
    <div class="glass rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-700/50">
        @if($histories->isEmpty())
            <div class="text-center py-16 space-y-4">
                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-300">Belum ada riwayat</h3>
                    <p class="text-sm text-slate-500 max-w-xs mx-auto">Kalimat yang Anda analisis setelah login akan tersimpan otomatis di sini.</p>
                </div>
                <a href="/analyze" class="inline-block bg-gradient-to-r from-teal-500 to-indigo-600 hover:from-teal-400 hover:to-indigo-500 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-lg shadow-teal-500/20">
                    Mulai Analisis Baru
                </a>
            </div>
        @else
            <!-- Desktop/Tablet List -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="py-4 px-2">Kalimat Arab</th>
                            <th class="py-4 px-2">Jenis Kalimat</th>
                            <th class="py-4 px-2">Tanggal Analisis</th>
                            <th class="py-4 px-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        @foreach($histories as $history)
                            <tr class="hover:bg-slate-800/20 transition duration-150">
                                <!-- Kalimat Arab -->
                                <td class="py-4 px-2 max-w-xs">
                                    <div class="text-2xl font-arabic text-slate-100 truncate dir-rtl" dir="rtl">
                                        {{ $history->input_text }}
                                    </div>
                                </td>
                                
                                <!-- Jenis Kalimat -->
                                <td class="py-4 px-2">
                                    <span class="px-2.5 py-0.5 text-xs font-medium bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 rounded-lg">
                                        {{ $history->analysis_result['sentence_structure'] ?? 'Jumlah Ismiyah' }}
                                    </span>
                                </td>

                                <!-- Tanggal -->
                                <td class="py-4 px-2 text-sm text-slate-400">
                                    {{ $history->created_at->diffForHumans() }}
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-2 text-right flex items-center justify-end space-x-2">
                                    <!-- Tombol Detail -->
                                    <a 
                                        href="{{ route('analyze.show', $history->id) }}" 
                                        class="px-3 py-1.5 bg-teal-500/10 text-teal-400 border border-teal-500/20 hover:bg-teal-500 hover:text-slate-900 rounded-lg text-xs font-bold transition flex items-center space-x-1"
                                    >
                                        <span>Lihat</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('history.destroy', $history->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="p-1.5 text-slate-500 hover:text-rose-400 hover:bg-rose-500/10 border border-transparent hover:border-rose-500/20 rounded-lg transition"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginasi Laravel Tailwind -->
            <div class="pt-6 border-t border-slate-800">
                {{ $histories->appends(['search' => $search])->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
