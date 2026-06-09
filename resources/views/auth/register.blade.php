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

            <!-- Errors -->
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
        </form>

        <!-- Footer -->
        <div class="mt-6 text-center text-xs text-[#5c6f60]">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-[#1b4332] hover:underline font-bold">Masuk Sekarang</a>
        </div>
    </div>
</div>
@endsection
