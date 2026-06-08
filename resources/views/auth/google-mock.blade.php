@extends('layouts.app')

@section('title', 'Simulasi Google Login - Smart Nahwu')

@section('content')
<div class="max-w-md mx-auto space-y-6 py-12">
    <div class="text-center space-y-2">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold border border-amber-200">
            <i class="fa-solid fa-triangle-exclamation"></i> Mode Pengembangan (Mock Google Login)
        </div>
        <h1 class="text-3xl font-extrabold text-[#1b4332]">
            Google Sign-In
        </h1>
        <p class="text-[#4a5d4e] text-sm">
            Simulasi login OAuth menggunakan akun Google di lingkungan lokal.
        </p>
    </div>

    <!-- Google Authentication Card -->
    <div class="kitab-box rounded-xl p-8 relative overflow-hidden bg-white border border-[#e6dec9] shadow-md">
        <!-- Google Logo -->
        <div class="flex justify-center mb-6">
            <svg class="w-12 h-12" viewBox="0 0 24 24" fill="currentColor">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
        </div>

        <div class="space-y-4">
            <h3 class="text-lg font-bold text-center text-[#1b4332] mb-4">Pilih Akun Simulasi</h3>

            <!-- Option 1: Mock Santri -->
            <form action="{{ route('auth.google.mock.callback') }}" method="POST">
                @csrf
                <input type="hidden" name="name" value="Santri Mock">
                <input type="hidden" name="email" value="santri.mock@gmail.com">
                <input type="hidden" name="role" value="santri">
                <button type="submit" class="w-full flex items-center justify-between p-4 bg-[#fdfbf7] hover:bg-[#f5ebd3] border border-[#e6dec9] rounded-xl transition duration-200 text-left group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#1b4332] text-white flex items-center justify-center font-bold">
                            S
                        </div>
                        <div>
                            <div class="font-bold text-[#1b4332] text-sm">Santri Mock</div>
                            <div class="text-[#5c6f60] text-xs">santri.mock@gmail.com</div>
                        </div>
                    </div>
                    <span class="text-xs px-2.5 py-1 bg-[#1b4332]/10 text-[#1b4332] font-semibold rounded-full uppercase">Santri</span>
                </button>
            </form>

            <!-- Option 2: Mock Admin -->
            <form action="{{ route('auth.google.mock.callback') }}" method="POST">
                @csrf
                <input type="hidden" name="name" value="Admin Mock">
                <input type="hidden" name="email" value="admin.mock@gmail.com">
                <input type="hidden" name="role" value="admin">
                <button type="submit" class="w-full flex items-center justify-between p-4 bg-[#fdfbf7] hover:bg-[#f5ebd3] border border-[#e6dec9] rounded-xl transition duration-200 text-left group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-amber-600 text-white flex items-center justify-center font-bold">
                            A
                        </div>
                        <div>
                            <div class="font-bold text-amber-800 text-sm">Admin Mock</div>
                            <div class="text-[#5c6f60] text-xs">admin.mock@gmail.com</div>
                        </div>
                    </div>
                    <span class="text-xs px-2.5 py-1 bg-amber-100 text-amber-800 font-semibold rounded-full uppercase">Admin</span>
                </button>
            </form>

            <!-- Custom User Collapsible -->
            <div x-data="{ open: false }" class="border-t border-[#e6dec9] pt-4 mt-6">
                <button @click="open = !open" type="button" class="w-full flex items-center justify-between text-xs font-semibold text-[#1b4332] hover:underline uppercase tracking-wider py-2">
                    <span>Gunakan Akun Kustom</span>
                    <i class="fa-solid" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>

                <div x-show="open" x-collapse class="mt-4 space-y-4 bg-[#fdfbf7] p-4 rounded-xl border border-[#e6dec9]">
                    <form action="{{ route('auth.google.mock.callback') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" name="name" placeholder="Ahmad Hisyam" required class="w-full bg-white border border-[#e6dec9] rounded-lg px-3 py-2 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/20">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Alamat Email</label>
                            <input type="email" name="email" placeholder="hisyam@gmail.com" required class="w-full bg-white border border-[#e6dec9] rounded-lg px-3 py-2 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/20">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-[#1b4332] uppercase tracking-wider">Peran (Role)</label>
                            <select name="role" required class="w-full bg-white border border-[#e6dec9] rounded-lg px-3 py-2 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/20">
                                <option value="santri">Santri</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-[#1b4332] hover:bg-[#2d5a45] text-white font-bold py-2.5 px-4 rounded-lg text-sm transition duration-200">
                            Masuk dengan Akun Kustom
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
