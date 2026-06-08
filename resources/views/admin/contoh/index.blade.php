@extends('layouts.admin')

@section('title', 'Kelola Contoh Kalimat - Smart Nahwu')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1b4332]">Kelola Contoh Kalimat</h1>
            <p class="text-sm text-[#5c6f60]">Daftar contoh kalimat Arab beserta terjemahannya per Bab.</p>
        </div>
        <a href="{{ route('admin.contoh.create') }}" class="px-4 py-2 bg-[#1b4332] hover:bg-[#2d5a45] text-white text-xs font-bold rounded-xl transition border border-[#1b4332] shadow-sm">
            + Tambah Contoh Baru
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
                        <th class="px-6 py-4">Bab</th>
                        <th class="px-6 py-4">Teks Arab</th>
                        <th class="px-6 py-4">Terjemahan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e6dec9] text-[#2b3a32] text-sm">
                    @forelse($examples as $example)
                        <tr class="hover:bg-[#fbf8f1]/40 transition">
                            <td class="px-6 py-4 font-bold text-[#5c6f60]">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-[#1b4332]/10 border border-[#1b4332]/20 text-[#1b4332] text-xs rounded-lg font-bold">
                                    {{ $example->bab->judul ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-[#1b4332] text-lg" dir="rtl">{{ $example->teks_arab }}</td>
                            <td class="px-6 py-4 text-xs text-[#5c6f60] max-w-xs truncate">{{ $example->terjemahan }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('admin.contoh.edit', $example->id) }}" class="px-3 py-1.5 bg-[#fcfbfa] hover:bg-[#f5f2eb] text-[#2b3a32] text-xs font-bold rounded-lg border border-[#e6dec9] transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.contoh.destroy', $example->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Hapus contoh kalimat ini?')">
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
                            <td colspan="5" class="px-6 py-8 text-center text-[#5c6f60]">Belum ada contoh kalimat tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($examples->hasPages())
            <div class="px-6 py-4 bg-[#fcfbfa] border-t border-[#e6dec9]">
                {{ $examples->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
