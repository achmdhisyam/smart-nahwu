@extends(request()->get('layout') === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('title', 'Profil Saya - Smart Nahwu')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header Page -->
    <div>
        <h1 class="text-3xl font-extrabold text-[#1b4332] flex items-center gap-2">
            <i class="fa-solid fa-user-gear text-[#b45309]"></i> Pengaturan Profil
        </h1>
        <p class="text-sm text-[#5c6f60]">Perbarui informasi profil Anda dan amankan akun Anda dengan mengganti kata sandi secara berkala.</p>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Left Side: Profile Summary -->
        <div class="space-y-4">
            <div class="kitab-box p-6 rounded-xl text-center space-y-4">
                <div class="w-20 h-20 bg-[#1b4332] text-[#dfb15b] border-2 border-[#b45309] rounded-full flex items-center justify-center mx-auto text-3xl font-bold shadow-md">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-[#133827] text-lg">{{ $user->name }}</h3>
                    <p class="text-xs text-[#5c6f60]">{{ $user->email }}</p>
                    <span class="inline-block mt-2 text-[10px] font-bold text-[#b45309] bg-[#fff2cc] border border-[#ffe599] px-2.5 py-1 rounded-md uppercase tracking-wider">
                        {{ $user->role === 'admin' ? 'Administrator' : 'Santri' }}
                    </span>
                </div>
                <div class="pt-4 border-t border-[#e6dec9]/60 text-left text-xs text-[#5c6f60] space-y-2">
                    <div class="flex justify-between">
                        <span>Bergabung Sejak:</span>
                        <span class="font-bold text-[#133827]">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Forms (Profile update & Password update) -->
        <div class="md:col-span-2 space-y-8">
            <!-- Form 1: Ubah Informasi Profil -->
            <div class="kitab-box p-6 rounded-xl space-y-6">
                <div class="flex items-center space-x-2 border-b border-[#e6dec9]/60 pb-3">
                    <i class="fa-solid fa-address-card text-[#b45309] text-lg"></i>
                    <h2 class="text-lg font-bold text-[#133827]">Informasi Profil</h2>
                </div>

                @if(session('success_profile'))
                    <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-700 text-sm flex items-center gap-2 font-medium">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        {{ session('success_profile') }}
                    </div>
                @endif

                <form action="{{ route('profil.update') }}" method="POST" class="space-y-4">
                    @csrf
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

                    <!-- Tombol Simpan -->
                    <div class="pt-2 text-right">
                        <button type="submit" class="bg-[#1b4332] hover:bg-[#255641] text-white font-bold py-2.5 px-6 rounded-lg text-xs transition border border-[#1b4332] shadow-sm cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Form 2: Ubah Password -->
            <div class="kitab-box p-6 rounded-xl space-y-6">
                <div class="flex items-center space-x-2 border-b border-[#e6dec9]/60 pb-3">
                    <i class="fa-solid fa-key text-[#b45309] text-lg"></i>
                    <h2 class="text-lg font-bold text-[#133827]">Ganti Kata Sandi</h2>
                </div>

                @if(session('success_password'))
                    <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-700 text-sm flex items-center gap-2 font-medium">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        {{ session('success_password') }}
                    </div>
                @endif

                <form action="{{ route('profil.password') }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Password Lama -->
                    <div class="space-y-1" x-data="{ show: false }">
                        <label for="current_password" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input 
                                :type="show ? 'text' : 'password'" 
                                name="current_password" 
                                id="current_password" 
                                class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40 pr-10"
                                required
                            />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#5c6f60] hover:text-[#1b4332] focus:outline-none">
                                <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="space-y-1" x-data="{ show: false }">
                        <label for="password" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Kata Sandi Baru</label>
                        <div class="relative">
                            <input 
                                :type="show ? 'text' : 'password'" 
                                name="password" 
                                id="password" 
                                class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40 pr-10"
                                required
                            />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#5c6f60] hover:text-[#1b4332] focus:outline-none">
                                <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="space-y-1" x-data="{ show: false }">
                        <label for="password_confirmation" class="block text-xs font-bold text-[#1b4332] uppercase tracking-wider">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <input 
                                :type="show ? 'text' : 'password'" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                class="w-full bg-[#fcfbfa] border border-[#e6dec9] rounded-lg px-4 py-2.5 text-sm text-[#2b3a32] focus:outline-none focus:ring-2 focus:ring-[#1b4332]/40 pr-10"
                                required
                            />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#5c6f60] hover:text-[#1b4332] focus:outline-none">
                                <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Simpan Password -->
                    <div class="pt-2 text-right">
                        <button type="submit" class="bg-[#b45309] hover:bg-[#9a4004] text-white font-bold py-2.5 px-6 rounded-lg text-xs transition border border-[#b45309] shadow-sm cursor-pointer">
                            Perbarui Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
