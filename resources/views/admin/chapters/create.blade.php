@extends('layouts.app')

@section('title', 'Tambah Bab - Smart Nahwu')

@section('content')
<div class="max-w-xl mx-auto space-y-6 py-6">
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.chapters.index') }}" class="text-sm text-[#1b4332] hover:text-[#b45309] font-bold">← Kembali</a>
    </div>
    
    <div>
        <h1 class="text-3xl font-extrabold text-[#1b4332]">Tambah Bab Baru</h1>
        <p class="text-sm text-[#5c6f60]">Masukkan judul dan definisi bab baru untuk alur belajar.</p>
    </div>

    <!-- Form Card -->
    <div class="glass bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#e6dec9]">
        <form action="{{ route('admin.chapters.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Errors -->
            @if($errors->any())
                <div class="p-4 bg-rose-100 border border-rose-200 rounded-xl text-rose-800 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="space-y-1">
                <label for="title" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Judul Bab</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title') }}"
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                    placeholder="Contoh: Bab Kalam, Bab Al-I'rab"
                    required
                >
            </div>

            <div class="space-y-1">
                <label for="definition" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Definisi / Penjelasan Singkat</label>
                <textarea 
                    name="definition" 
                    id="definition" 
                    rows="4" 
                    class="w-full bg-white border border-[#e6dec9] rounded-xl p-4 text-[#2b3a32] placeholder-[#a1b0a5] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] text-sm leading-relaxed"
                    placeholder="Tuliskan pengertian dasar bab ini..."
                    required
                >{{ old('definition') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label for="order_num" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">No Urut Tampil</label>
                    <input 
                        type="number" 
                        name="order_num" 
                        id="order_num" 
                        value="{{ old('order_num', 1) }}"
                        class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                        required
                    >
                </div>

                <div class="space-y-1">
                    <label for="learning_step" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Langkah Belajar (Step)</label>
                    <input 
                        type="number" 
                        name="learning_step" 
                        id="learning_step" 
                        value="{{ old('learning_step', 1) }}"
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
                Simpan Bab
            </button>
        </form>
    </div>
</div>
@endsection
