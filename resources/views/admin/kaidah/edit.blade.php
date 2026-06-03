@extends('layouts.app')

@section('title', 'Edit Kaidah - Smart Nahwu')

@section('content')
<div class="max-w-xl mx-auto space-y-6 py-6">
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.rules.index') }}" class="text-sm text-[#1b4332] hover:text-[#b45309] font-bold">← Kembali</a>
    </div>
    
    <div>
        <h1 class="text-3xl font-extrabold text-[#1b4332]">Edit Kaidah: {{ $rule->kode_kaidah }}</h1>
        <p class="text-sm text-[#5c6f60]">Modifikasi bab rujukan dan isi teks kaidah.</p>
    </div>

    <!-- Form Card -->
    <div class="glass bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#e6dec9]">
        <form action="{{ route('admin.rules.update', $rule->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Errors -->
            @if($errors->any())
                <div class="p-4 bg-rose-100 border border-rose-200 rounded-xl text-rose-800 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="space-y-1">
                <label for="bab_id" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Bab Rujukan</label>
                <select 
                    name="bab_id" 
                    id="bab_id"
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] text-sm"
                    required
                >
                    @foreach($chapters as $chapter)
                        <option value="{{ $chapter->id }}" {{ $rule->bab_id == $chapter->id ? 'selected' : '' }}>
                            {{ $chapter->judul }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label for="kode_kaidah" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Kode Kaidah (Unik)</label>
                <input 
                    type="text" 
                    name="kode_kaidah" 
                    id="kode_kaidah" 
                    value="{{ old('kode_kaidah', $rule->kode_kaidah) }}"
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] font-mono text-sm"
                    required
                >
            </div>

            <div class="space-y-1">
                <label for="teks_kaidah" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Teks Bunyi Kaidah</label>
                <textarea 
                    name="teks_kaidah" 
                    id="teks_kaidah" 
                    rows="5" 
                    class="w-full bg-white border border-[#e6dec9] rounded-xl p-4 text-[#2b3a32] placeholder-[#a1b0a5] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] text-sm leading-relaxed"
                    required
                >{{ old('teks_kaidah', $rule->teks_kaidah) }}</textarea>
            </div>

            <button 
                type="submit" 
                class="w-full bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-3 px-6 rounded-xl shadow-sm transition duration-300 transform hover:scale-[1.01] border border-[#1b4332] cursor-pointer"
            >
                Perbarui Kaidah
            </button>
        </form>
    </div>
</div>
@endsection
