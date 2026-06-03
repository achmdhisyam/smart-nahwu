@extends('layouts.app')

@section('title', 'Edit Pengguna - Admin Smart Nahwu')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="space-y-1">
        <a href="{{ route('admin.pengguna.index') }}" class="text-xs text-[#1b4332] hover:text-[#b45309] font-bold">← Kembali ke Daftar Pengguna</a>
        <h1 class="text-3xl font-extrabold text-[#1b4332]">Edit Data Pengguna</h1>
        <p class="text-sm text-[#5c6f60]">Perbarui data profil, peran, atau reset kata sandi milik <strong>{{ $user->name }}</strong>.</p>
    </div>

    <!-- Form Card -->
    <div class="kitab-box p-8 rounded-xl">
        <form action="{{ route('admin.pengguna.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="space-y-1">
                <label for="name" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $user->name) }}"
                    class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40"
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
                    value="{{ old('email', $user->email) }}"
                    class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40"
                    required
                />
                @error('email')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role (Disable edit if it's the current logged in user to avoid lock out) -->
            <div class="space-y-1">
                <label for="role" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Peran (Role)</label>
                @if($user->id !== auth()->id())
                    <select 
                        name="role" 
                        id="role"
                        class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40"
                        required
                    >
                        <option value="santri" {{ old('role', $user->role) === 'santri' ? 'selected' : '' }}>Santri (Siswa)</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator (Pengelola)</option>
                    </select>
                @else
                    <input type="hidden" name="role" value="{{ $user->role }}" />
                    <div class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed select-none">
                        {{ ucfirst($user->role) }} <span class="text-xs text-gray-400 font-semibold">(Peran Anda sendiri tidak dapat diubah)</span>
                    </div>
                @endif
                @error('role')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Box for Optional Password Reset -->
            <div class="p-4 bg-[#fff2cc] border border-[#ffe599] text-[#7f6000] text-xs rounded-xl space-y-1">
                <p class="font-bold flex items-center gap-1">
                    <i class="fa-solid fa-circle-info"></i> Reset Kata Sandi Pengguna (Opsional)
                </p>
                <p>Biarkan kolom kata sandi di bawah ini kosong jika Anda tidak ingin mengubah/mereset kata sandi pengguna.</p>
            </div>

            <!-- Kata Sandi Baru -->
            <div class="space-y-1">
                <label for="password" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Kata Sandi Baru</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40"
                    placeholder="Kosongkan jika tidak ingin mereset..."
                />
                @error('password')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Kata Sandi Baru -->
            <div class="space-y-1">
                <label for="password_confirmation" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Konfirmasi Kata Sandi Baru</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40"
                    placeholder="Kosongkan jika tidak ingin mereset..."
                />
            </div>

            <!-- Buttons -->
            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-[#e6dec9]/60">
                <a href="{{ route('admin.pengguna.index') }}" class="text-xs font-bold text-[#5c6f60] hover:text-[#2b3a32] px-4 py-2.5 transition">Batal</a>
                <button type="submit" class="bg-[#b45309] hover:bg-[#9a4004] text-white font-bold py-2.5 px-6 rounded-lg text-xs transition border border-[#b45309] shadow-sm cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
