@extends('layouts.app')

@section('title', 'Tambah Pengguna - Admin Smart Nahwu')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="space-y-1">
        <a href="{{ route('admin.pengguna.index') }}" class="text-xs text-[#1b4332] hover:text-[#b45309] font-bold">← Kembali ke Daftar Pengguna</a>
        <h1 class="text-3xl font-extrabold text-[#1b4332]">Tambah Pengguna Baru</h1>
        <p class="text-sm text-[#5c6f60]">Buat akun pengguna baru dengan role Santri atau Administrator.</p>
    </div>

    <!-- Form Card -->
    <div class="kitab-box p-8 rounded-xl">
        <form action="{{ route('admin.pengguna.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nama -->
            <div class="space-y-1">
                <label for="name" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}"
                    class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40"
                    placeholder="Masukkan nama lengkap..."
                    required
                />
                @error('name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-1">
                <label for="email" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}"
                    class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40"
                    placeholder="nama@email.com"
                    required
                />
                @error('email')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div class="space-y-1">
                <label for="role" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Peran (Role)</label>
                <select 
                    name="role" 
                    id="role"
                    class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40"
                    required
                >
                    <option value="santri" {{ old('role') === 'santri' ? 'selected' : '' }}>Santri (Siswa)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Pengelola)</option>
                </select>
                @error('role')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kata Sandi -->
            <div class="space-y-1">
                <label for="password" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Kata Sandi</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40"
                    placeholder="Minimal 8 karakter..."
                    required
                />
                @error('password')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Kata Sandi -->
            <div class="space-y-1">
                <label for="password_confirmation" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Konfirmasi Kata Sandi</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40"
                    placeholder="Ulangi kata sandi..."
                    required
                />
            </div>

            <!-- Buttons -->
            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-[#e6dec9]/60">
                <a href="{{ route('admin.pengguna.index') }}" class="text-xs font-bold text-[#5c6f60] hover:text-[#2b3a32] px-4 py-2.5 transition">Batal</a>
                <button type="submit" class="bg-[#1b4332] hover:bg-[#255641] text-white font-bold py-2.5 px-6 rounded-lg text-xs transition border border-[#1b4332] shadow-sm cursor-pointer">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
