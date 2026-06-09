@extends('layouts.app')

@section('title', 'Analisis Kalimat Arab - Smart Nahwu')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header Banner -->
    <div class="text-center space-y-3">
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl text-[#1b4332]">
            Asisten Analisis Nahwu & Shorof
        </h1>
        <p class="text-[#4a5d4e] text-lg max-w-xl mx-auto">
            Ketik kalimat Arab (berharakat maupun gundul) untuk membedah kedudukan I'rab dan perubahan morfologi katanya secara instan.
        </p>
    </div>

    <!-- Error Alerts -->
    @if($errors->any())
        <div class="p-4 bg-rose-100 border border-rose-200 rounded-xl text-rose-800 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form Input Card -->
    <div class="kitab-box rounded-xl p-6 sm:p-8 relative overflow-hidden" x-data="{ isSubmitting: false }">
        <form action="{{ route('analisis.process') }}" method="POST" class="space-y-6" @submit="isSubmitting = true">
            @csrf
            
            <div class="space-y-2">
                <label for="input_text" class="block text-sm font-semibold text-[#1b4332]">
                    Input Kalimat Bahasa Arab:
                </label>
                <textarea 
                    name="input_text" 
                    id="input_text" 
                    rows="4" 
                    dir="rtl"
                    class="w-full bg-white/95 border border-[#e6dec9] rounded-2xl p-4 text-3xl font-arabic leading-relaxed text-right text-[#133827] placeholder-[#a1b0a5] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] transition duration-300 shadow-inner"
                    placeholder="أَدْخِلِ الْجُمْلَةَ الْعَرَبِيَّةَ هُنَا..."
                    required
                >{{ old('input_text') }}</textarea>
            </div>


            <div class="flex justify-end">
                <button 
                    type="submit" 
                    :disabled="isSubmitting"
                    class="w-full sm:w-auto bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-3.5 px-8 rounded-xl shadow-md shadow-[#1b4332]/10 transition duration-300 flex items-center justify-center space-x-2 cursor-pointer border border-[#1b4332] disabled:opacity-75 disabled:cursor-wait"
                >
                    <span x-show="!isSubmitting">Bedah Kalimat</span>
                    <span x-show="isSubmitting" style="display: none;">Menganalisis...</span>
                    
                    <i class="fa-solid fa-feather-pointed" x-show="!isSubmitting"></i>
                    <i class="fa-solid fa-spinner fa-spin" x-show="isSubmitting" style="display: none;"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
