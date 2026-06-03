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

            <div class="space-y-1">
                <label for="password" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Kata Sandi</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    x-model="password"
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                    placeholder="••••••••"
                    required
                >
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
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-[#e6dec9]"></span></div>
            <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-[#4a5d4e]">Uji Coba Demo</span></div>
        </div>

        <!-- Quick Demo login buttons (Premium UX) -->
        <div class="grid grid-cols-2 gap-3">
            <button 
                @click="email = 'santri@example.com'; password = 'password'"
                class="px-3 py-2 bg-[#fcfbfa] hover:bg-[#f5f2eb] text-[#2b3a32] text-xs font-semibold rounded-xl border border-[#e6dec9] transition flex flex-col items-center justify-center space-y-1 cursor-pointer"
            >
                <span class="font-bold text-[#1b4332]">Akun Santri</span>
                <span class="text-[10px] text-[#5c6f60]">santri@example.com</span>
            </button>
            <button 
                @click="email = 'admin@example.com'; password = 'password'"
                class="px-3 py-2 bg-[#fcfbfa] hover:bg-[#f5f2eb] text-[#2b3a32] text-xs font-semibold rounded-xl border border-[#e6dec9] transition flex flex-col items-center justify-center space-y-1 cursor-pointer"
            >
                <span class="font-bold text-[#b45309]">Akun Admin</span>
                <span class="text-[10px] text-[#5c6f60]">admin@example.com</span>
            </button>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center text-xs text-[#5c6f60]">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-[#1b4332] hover:underline font-bold">Daftar Sekarang</a>
        </div>
    </div>
</div>
@endsection
