@extends('layouts.app')

@section('title', 'Masuk - Smart Nahwu')

@section('content')
<div class="max-w-md mx-auto space-y-6 py-12" x-data="{ email: '', password: '' }">
    <div class="text-center space-y-2">
        <h1 class="text-3xl font-extrabold text-[#1b4332]">
            Masuk ke Smart Nahwu
        </h1>
        <p class="text-[#4a5d4e] text-sm">
            Mulai belajar Jurumiyah secara terstruktur dan evaluasi dengan kuis.
        </p>
    </div>

    <!-- Traditional Card -->
    <div class="kitab-box rounded-xl p-8 relative overflow-hidden">
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
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
                    x-model="email"
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                    placeholder="nama@email.com"
                    required
                >
            </div>

            <div class="space-y-1" x-data="{ show: false }">
                <label for="password" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Kata Sandi</label>
                <div class="relative">
                    <input 
                        :type="show ? 'text' : 'password'" 
                        name="password" 
                        id="password" 
                        x-model="password"
                        class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] pr-10"
                        placeholder="••••••••"
                        required
                    >
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#5c6f60] hover:text-[#1b4332] focus:outline-none">
                        <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center space-x-2 text-[#4a5d4e] cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded bg-white border-[#e6dec9] text-[#1b4332] focus:ring-0">
                    <span>Ingat Saya</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-[#b45309] hover:underline font-semibold">Lupa Password?</a>
            </div>

            <button 
                type="submit" 
                class="w-full bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-3 px-6 rounded-xl shadow-sm transition duration-300 transform hover:scale-[1.01] cursor-pointer border border-[#1b4332]"
            >
                Masuk
            </button>

            <div class="relative my-4 flex items-center justify-center">
                <span class="absolute px-3 bg-[#fdfbf7] text-[#5c6f60] text-xs uppercase tracking-wider">Atau</span>
                <div class="w-full border-t border-[#e6dec9]"></div>
            </div>

            <a 
                href="{{ route('auth.google') }}"
                class="w-full flex items-center justify-center gap-3 bg-white hover:bg-slate-50 text-slate-700 font-semibold py-3 px-6 rounded-xl border border-[#e6dec9] shadow-sm transition duration-300 transform hover:scale-[1.01] cursor-pointer"
            >
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                <span>Masuk dengan Google</span>
            </a>
        </form>



        <!-- Footer -->
        <div class="mt-6 text-center text-xs text-[#5c6f60]">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-[#1b4332] hover:underline font-bold">Daftar Sekarang</a>
        </div>
    </div>
</div>
@endsection
