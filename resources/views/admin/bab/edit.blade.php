@extends('layouts.admin')

@section('title', 'Edit Bab - Smart Nahwu')

@section('content')
<div class="max-w-xl mx-auto space-y-6 py-6">
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.bab.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-[#fcfbfa] hover:bg-[#f5f2eb] text-[#1b4332] text-xs font-bold rounded-xl border border-[#e6dec9] transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
    
    <div>
        <h1 class="text-3xl font-extrabold text-[#1b4332]">Edit Bab: {{ $chapter->judul }}</h1>
        <p class="text-sm text-[#5c6f60]">Modifikasi informasi bab dan alur belajar.</p>
    </div>

    <!-- Form Card -->
    <div class="glass bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#e6dec9]">
        <form action="{{ route('admin.bab.update', $chapter->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Errors -->
            @if($errors->any())
                <div class="p-4 bg-rose-100 border border-rose-200 rounded-xl text-rose-800 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="space-y-1">
                <label for="judul" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Judul Bab</label>
                <input 
                    type="text" 
                    name="judul" 
                    id="judul" 
                    value="{{ old('judul', $chapter->judul) }}"
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                    required
                >
            </div>

            <div class="space-y-1">
                <label for="definisi" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Definisi / Penjelasan Singkat</label>
                <textarea 
                    name="definisi" 
                    id="definisi" 
                    rows="4" 
                    class="w-full bg-white border border-[#e6dec9] rounded-xl p-4 text-[#2b3a32] placeholder-[#a1b0a5] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] text-sm leading-relaxed"
                    required
                >{{ old('definisi', $chapter->definisi) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label for="nomor_urut" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">No Urut Tampil</label>
                    <input 
                        type="number" 
                        name="nomor_urut" 
                        id="nomor_urut" 
                        value="{{ old('nomor_urut', $chapter->nomor_urut) }}"
                        class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                        required
                    >
                </div>

                <div class="space-y-1">
                    <label for="langkah_belajar" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Langkah Belajar (Step)</label>
                    <input 
                        type="number" 
                        name="langkah_belajar" 
                        id="langkah_belajar" 
                        value="{{ old('langkah_belajar', $chapter->langkah_belajar) }}"
                        min="1"
                        max="9"
                        class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                        required
                    >
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-3 px-6 rounded-xl shadow-sm transition duration-300 transform hover:scale-[1.01] border border-[#1b4332] cursor-pointer"
            >
                Perbarui Bab
            </button>
        </form>
    </div>
</div>
@endsection
