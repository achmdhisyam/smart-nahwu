@extends('layouts.app')

@section('title', 'Daftar Akun - Smart Nahwu')

@section('content')
<div class="max-w-md mx-auto space-y-6 py-12">
    <div class="text-center space-y-2">
        <h1 class="text-3xl font-extrabold text-[#1b4332]">
            Daftar Akun Baru
        </h1>
        <p class="text-[#4a5d4e] text-sm">
            Bergabunglah untuk mencatat progres belajar dan melacak sertifikat pencapaian.
        </p>
    </div>

    <!-- Traditional Card -->
    <div class="kitab-box rounded-xl p-8 relative overflow-hidden">
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Session Messages & Errors -->
            @if(session('error'))
                <div class="p-4 bg-rose-100 border border-rose-200 rounded-xl text-rose-800 text-xs">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="p-4 bg-emerald-100 border border-emerald-200 rounded-xl text-emerald-800 text-xs">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-rose-100 border border-rose-200 rounded-xl text-rose-800 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="space-y-1">
                <label for="name" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}"
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                    placeholder="Nama Anda"
                    required
                >
            </div>

            <div class="space-y-1">
                <label for="email" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}"
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
                        class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] pr-10"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#5c6f60] hover:text-[#1b4332] focus:outline-none">
                        <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <div class="space-y-1" x-data="{ show: false }">
                <label for="password_confirmation" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <input 
                        :type="show ? 'text' : 'password'" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332] pr-10"
                        placeholder="Ulangi kata sandi"
                        required
                    >
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#5c6f60] hover:text-[#1b4332] focus:outline-none">
                        <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-3 px-6 rounded-xl shadow-sm transition duration-300 transform hover:scale-[1.01] mt-2 border border-[#1b4332]"
            >
                Daftar Akun
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
                <span>Daftar dengan Google</span>
            </a>
        </form>

        <!-- Footer -->
        <div class="mt-6 text-center text-xs text-[#5c6f60]">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-[#1b4332] hover:underline font-bold">Masuk Sekarang</a>
        </div>
    </div>
</div>
@endsection
