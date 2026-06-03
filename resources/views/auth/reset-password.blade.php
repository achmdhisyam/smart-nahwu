@extends('layouts.app')

@section('title', 'Reset Password - Smart Nahwu')

@section('content')
<div class="max-w-md mx-auto space-y-6 py-12">
    <div class="text-center space-y-2">
        <h1 class="text-3xl font-extrabold text-[#1b4332]">
            Reset Kata Sandi
        </h1>
        <p class="text-[#4a5d4e] text-sm">
            Masukkan kata sandi baru Anda di bawah ini untuk memulihkan akun Anda.
        </p>
    </div>

    <!-- Traditional Card -->
    <div class="kitab-box rounded-xl p-8 relative overflow-hidden">
        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Errors -->
            @if($errors->any())
                <div class="p-4 bg-rose-100 border border-rose-200 rounded-xl text-rose-800 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Email -->
            <div class="space-y-1">
                <label for="email" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="w-full bg-[#fbf8f1] border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none"
                    value="{{ old('email', $email) }}"
                    required
                    readonly
                >
            </div>

            <!-- Password Baru -->
            <div class="space-y-1">
                <label for="password" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Kata Sandi Baru</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                    placeholder="••••••••"
                    required
                    autoFocus
                >
            </div>

            <!-- Konfirmasi Password -->
            <div class="space-y-1">
                <label for="password_confirmation" class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Konfirmasi Kata Sandi Baru</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="w-full bg-white border border-[#e6dec9] rounded-xl px-4 py-3 text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/30 focus:border-[#1b4332]"
                    placeholder="••••••••"
                    required
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-3 px-6 rounded-xl shadow-sm transition duration-300 transform hover:scale-[1.01] cursor-pointer border border-[#1b4332]"
            >
                Atur Ulang Kata Sandi
            </button>
        </form>
    </div>
</div>
@endsection
