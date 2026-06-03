@extends('layouts.app')

@section('title', 'Tambah Kaidah - Smart Nahwu')

@section('content')
<div class="max-w-xl mx-auto space-y-6 py-6">
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.rules.index') }}" class="text-sm text-[#1b4332] hover:text-[#b45309] font-bold">← Kembali</a>
    </div>
    
    <div>
        <h1 class="text-3xl font-extrabold text-[#1b4332]">Tambah Kaidah Baru</h1>
        <p class="text-sm text-[#5c6f60]">Masukkan kode kaidah, bab rujukan, dan deskripsi bunyi kaidah.</p>
    </div>

    <!-- Form Card -->
    <div class="glass bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#e6dec9]">
        <form action="{{ route('admin.rules.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Errors -->
            @if($errors->any())
                <div class="p-4 bg-rose-100 border border-rose-200 rounded-xl text-rose-800 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="space-y-1">
                <label for="chapter_id" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Bab Rujukan</label>
                <select 
                    name="chapter_id" 
                    id="chapter_id"
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] text-sm"
                    required
                >
                    <option value="" disabled selected>Pilih Bab Jurumiyah...</option>
                    @foreach($chapters as $chapter)
                        <option value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label for="rule_code" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Kode Kaidah (Unik)</label>
                <input 
                    type="text" 
                    name="rule_code" 
                    id="rule_code" 
                    value="{{ old('rule_code', 'RULE_') }}"
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] font-mono text-sm"
                    placeholder="Contoh: RULE_KALAM_1"
                    required
                >
            </div>

            <div class="space-y-1">
                <label for="rule_text" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Teks Bunyi Kaidah</label>
                <textarea 
                    name="rule_text" 
                    id="rule_text" 
                    rows="5" 
                    class="w-full bg-white border border-[#e6dec9] rounded-xl p-4 text-[#2b3a32] placeholder-[#a1b0a5] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] text-sm leading-relaxed"
                    placeholder="Tuliskan bunyi teks kaidah lengkap..."
                    required
                >{{ old('rule_text') }}</textarea>
            </div>

            <button 
                type="submit" 
                class="w-full bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-3 px-6 rounded-xl shadow-sm transition duration-300 transform hover:scale-[1.01] border border-[#1b4332] cursor-pointer"
            >
                Simpan Kaidah
            </button>
        </form>
    </div>
</div>
@endsection
