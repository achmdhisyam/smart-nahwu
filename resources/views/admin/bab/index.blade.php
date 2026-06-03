@extends('layouts.app')

@section('title', 'Kelola Bab - Smart Nahwu')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1b4332]">Kelola Bab Jurumiyah</h1>
            <p class="text-sm text-[#5c6f60]">Daftar bab pembagian materi Kitab Matan Al-Ajurrumiyyah.</p>
        </div>
        <a href="{{ route('admin.chapters.create') }}" class="px-4 py-2 bg-[#1b4332] hover:bg-[#2d5a45] text-white text-xs font-bold rounded-xl transition border border-[#1b4332] shadow-sm">
            + Tambah Bab Baru
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 bg-emerald-100 border border-emerald-200 rounded-2xl text-emerald-800 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="glass bg-white rounded-3xl overflow-hidden shadow-sm border border-[#e6dec9]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcfbfa] border-b border-[#e6dec9] text-[#4a5d4e] text-xs uppercase tracking-wider font-bold">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Judul Bab</th>
                        <th class="px-6 py-4">Definisi/Penjelasan</th>
                        <th class="px-6 py-4">Langkah Belajar</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e6dec9] text-[#2b3a32] text-sm">
                    @forelse($chapters as $chapter)
                        <tr class="hover:bg-[#fbf8f1]/40 transition">
                            <td class="px-6 py-4 font-bold text-[#5c6f60]">{{ $chapter->nomor_urut }}</td>
                            <td class="px-6 py-4 font-bold text-[#1b4332] text-base">{{ $chapter->judul }}</td>
                            <td class="px-6 py-4 max-w-xs truncate text-xs text-[#5c6f60]">{{ $chapter->definisi }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-[#1b4332]/10 border border-[#1b4332]/20 text-[#1b4332] text-xs rounded-lg font-bold">
                                    Step {{ $chapter->langkah_belajar }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('admin.chapters.edit', $chapter->id) }}" class="px-3 py-1.5 bg-[#fcfbfa] hover:bg-[#f5f2eb] text-[#2b3a32] text-xs font-bold rounded-lg border border-[#e6dec9] transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.chapters.destroy', $chapter->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bab ini beserta seluruh kaidah di dalamnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-100 hover:bg-rose-200 border border-rose-200 text-rose-800 text-xs font-bold rounded-lg transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-[#5c6f60]">Belum ada data bab tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($chapters->hasPages())
            <div class="px-6 py-4 bg-[#fcfbfa] border-t border-[#e6dec9]">
                {{ $chapters->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
