@extends('layouts.app')

@section('title', 'Lupa Password - Smart Nahwu')

@section('content')
<div class="max-w-md mx-auto space-y-6 py-12">
    <div class="text-center space-y-2">
        <h1 class="text-3xl font-extrabold text-[#1b4332]">
            Lupa Password Anda?
        </h1>
        <p class="text-[#4a5d4e] text-sm">
            Masukkan alamat email Anda untuk menerima tautan reset kata sandi baru.
        </p>
    </div>

    <!-- Traditional Card -->
    <div class="kitab-box rounded-xl p-8 relative overflow-hidden">
        @if(session('status'))
            <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-700 text-xs mb-5 font-semibold">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Errors -->
            @if($errors->any())
                <div class="p-4 bg-rose-100 border border-rose-200 rounded-xl text-rose-800 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="space-y-1">
                <label for="email" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                    placeholder="nama@email.com"
                    required
                    value="{{ old('email') }}"
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-3 px-6 rounded-xl shadow-sm transition duration-300 transform hover:scale-[1.01] cursor-pointer border border-[#1b4332]"
            >
                Kirim Tautan Reset Password
            </button>
        </form>

        <!-- Back to login link -->
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-xs text-[#b45309] hover:underline font-semibold flex items-center justify-center gap-1">
                <i class="fa-solid fa-arrow-left-long"></i> Kembali ke Halaman Masuk
            </a>
        </div>
    </div>
</div>
@endsection
