<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart Nahwu - Asisten Pembelajaran Jurumiyah')</title>
    
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for traditional/classic icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        arabic: ['Amiri', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- AlpineJS for Interactive Micro-interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- SweetAlert2 for Premium UX Prompts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #fbf8f1; /* Warm Ivory / Kertas Kitab Kuning */
            color: #2b3a32; /* Deep Charcoal Green */
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        button, input, select, textarea {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-arabic {
            font-family: 'Amiri', serif !important;
        }
        .kitab-box {
            background-color: #ffffff;
            border: 1px solid #e2d9c0;
            box-shadow: 0 2px 4px rgba(27, 67, 50, 0.04);
        }
        /* Custom scrollbar for premium sidebar feel */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(27, 67, 50, 0.05);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(27, 67, 50, 0.2);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(27, 67, 50, 0.3);
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex bg-[#fbf8f1]" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    @auth
        <!-- Sidebar Wrapper for Authenticated Users -->
        <!-- Backdrop for mobile -->
        <div 
            class="fixed inset-0 z-40 bg-[#1b4332]/40 backdrop-blur-sm lg:hidden transition-opacity duration-300"
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            x-cloak
        ></div>

        <!-- Sidebar Content -->
        <aside 
            class="fixed inset-y-0 left-0 z-50 bg-[#1b4332] text-white flex flex-col border-[#b45309] transform lg:sticky lg:top-0 lg:h-screen transition-all duration-300 ease-in-out shadow-2xl lg:shadow-none overflow-hidden"
            :class="sidebarOpen ? 'translate-x-0 w-72 border-r-4' : '-translate-x-full w-0 border-r-0'"
        >
            <!-- Logo / Brand Header -->
            <div class="h-20 flex items-center px-6 border-b border-[#dfb15b]/20 bg-[#133225]">
                <a href="/" class="flex items-center space-x-3">
                    <span class="text-xl font-extrabold text-[#fbf8f1] tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-mosque text-[#dfb15b] text-2xl"></i>
                        <span>Smart Nahwu</span>
                    </span>
                </a>
                <!-- Close Button for Mobile -->
                <button @click="sidebarOpen = false" class="lg:hidden ml-auto text-white hover:text-[#dfb15b] focus:outline-none transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- User Briefing -->
            <div class="px-6 py-4 bg-[#173b2c] border-b border-[#dfb15b]/10 flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-[#dfb15b] text-[#1b4332] font-extrabold flex items-center justify-center shadow-md border border-[#dfb15b]/20">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <span class="block text-xs text-[#dfb15b] font-bold tracking-wider uppercase">
                        {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Santri' }}
                    </span>
                    <span class="block text-sm font-semibold truncate text-white" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</span>
                </div>
            </div>

            <!-- Sidebar Navigation Menu -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <!-- Dashboard Link -->
                @auth
                <a 
                    href="{{ route('dashboard') }}" 
                    class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('dashboard') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
                >
                    <i class="fa-solid fa-house mr-3.5 text-base {{ request()->routeIs('dashboard') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                    Dashboard
                </a>
                @endauth

                <!-- Modul Belajar Link -->
                <a 
                    href="{{ route('belajar.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('belajar*') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
                >
                    <i class="fa-solid fa-book-open mr-3.5 text-base {{ request()->routeIs('belajar*') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                    Modul Belajar
                </a>

                <!-- Analisis Baru Link -->
                <a 
                    href="/analisis" 
                    class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->is('analisis') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
                >
                    <i class="fa-solid fa-wand-magic-sparkles mr-3.5 text-base {{ request()->is('analisis') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                    Analisis Baru
                </a>

                <!-- Riwayat Analisis Link -->
                <a 
                    href="/riwayat" 
                    class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->is('riwayat*') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
                >
                    <i class="fa-solid fa-history mr-3.5 text-base {{ request()->is('riwayat*') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                    Riwayat Analisis
                </a>

                <!-- Latihan Kuis Link -->
                <a 
                    href="/kuis" 
                    class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->is('kuis*') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
                >
                    <i class="fa-solid fa-graduation-cap mr-3.5 text-base {{ request()->is('kuis*') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                    Latihan Kuis
                </a>

                <!-- Pengaturan Profil Link -->
                <a 
                    href="{{ route('profil.edit') }}" 
                    class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('profil.edit') && request()->get('layout') !== 'admin' ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
                >
                    <i class="fa-solid fa-user-gear mr-3.5 text-base {{ request()->routeIs('profil.edit') && request()->get('layout') !== 'admin' ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                    Pengaturan Profil
                </a>
            </nav>

            <!-- Sidebar Footer Actions -->
            <div class="p-4 border-t border-[#dfb15b]/10 bg-[#133225] space-y-2">
                @if(auth()->user()->isAdmin())
                    <a href="/admin" class="flex items-center justify-center w-full px-4 py-2 text-xs font-bold text-white bg-[#b45309] hover:bg-[#9a4004] rounded-lg transition shadow-sm gap-2">
                        <i class="fa-solid fa-lock-open"></i>
                        <span>Admin Panel</span>
                    </a>
                @endif
                
                <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full px-4 py-2 text-xs font-bold text-white bg-transparent hover:bg-rose-900 border border-white/20 hover:border-rose-900 rounded-lg transition gap-2 cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>
    @endauth

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- Top Navigation Bar -->
        <header class="bg-[#1b4332] border-b-4 border-[#b45309] shadow-md sticky top-0 z-30">
            @auth
                <div class="h-20 px-6 flex items-center justify-between w-full">
                    <!-- Mobile Toggle Button (Only when authenticated) -->
                    <button 
                        @click="sidebarOpen = !sidebarOpen" 
                        class="text-[#fbf8f1] hover:text-[#dfb15b] p-2 focus:outline-none transition mr-4"
                    >
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>

                    <!-- Brand Info / Dynamic Title -->
                    <div class="hidden sm:flex items-center space-x-2">
                        <span class="text-sm font-semibold text-[#dfb15b] uppercase tracking-wider">Asisten Pembelajaran Jurumiyah</span>
                    </div>

                    <!-- Header Profile Actions -->
                    <div class="flex items-center space-x-4">
                        <span class="text-xs text-[#fbf8f1] font-semibold hidden md:inline-block">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                        
                        <a href="{{ route('profil.edit') }}" class="w-9 h-9 rounded-full bg-[#dfb15b] hover:bg-white text-[#1b4332] font-bold border border-[#dfb15b]/30 flex items-center justify-center transition shadow-md" title="Pengaturan Profil">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </a>
                    </div>
                </div>
            @else
                <!-- Header for Guests -->
                <div class="w-full relative" x-data="{ mobileMenuOpen: false }">
                    <div class="max-w-6xl mx-auto w-full flex justify-between items-center h-20 px-6">
                        <a href="/" class="flex items-center space-x-2">
                            <span class="text-2xl font-extrabold text-[#fbf8f1] tracking-wider flex items-center gap-2">
                                <i class="fa-solid fa-mosque text-[#dfb15b]"></i> Smart Nahwu
                            </span>
                        </a>

                        <!-- Desktop links for Guests -->
                        <nav class="hidden md:flex items-center space-x-6 text-sm font-semibold">
                            <a href="{{ route('belajar.index') }}" class="hover:text-[#dfb15b] text-[#fbf8f1] transition py-1">Modul Belajar</a>
                            <a href="/analisis" class="hover:text-[#dfb15b] text-[#fbf8f1] transition py-1">Analisis Baru</a>
                            <a href="javascript:void(0)" onclick="showLoginAlert()" class="hover:text-[#dfb15b] text-[#fbf8f1] transition py-1">Latihan Kuis</a>
                            <span class="text-[#dfb15b]/40">|</span>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('login') }}" class="px-4 py-2 border-2 border-[#dfb15b] text-[#dfb15b] hover:bg-[#dfb15b] hover:text-[#1b4332] font-bold rounded-xl transition">Masuk</a>
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-[#b45309] hover:bg-[#9a4004] text-white font-bold rounded-xl shadow-md transition">Daftar</a>
                            </div>
                        </nav>

                        <!-- Mobile Hamburger for Guests -->
                        <button 
                            @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="md:hidden text-[#fbf8f1] hover:text-[#dfb15b] focus:outline-none transition p-1"
                        >
                            <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                        </button>
                    </div>

                    <!-- Mobile Navigation Dropdown Menu for Guests -->
                    <div 
                        x-show="mobileMenuOpen" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        class="md:hidden absolute top-full left-0 w-full bg-[#1b4332] border-b-4 border-[#b45309] shadow-xl px-6 pb-6 pt-2 z-40"
                        x-cloak
                    >
                        <nav class="flex flex-col space-y-4 text-sm font-semibold w-full">
                            <a href="{{ route('belajar.index') }}" @click="mobileMenuOpen = false" class="hover:text-[#dfb15b] text-[#fbf8f1] transition py-2 block">Modul Belajar</a>
                            <a href="/analisis" @click="mobileMenuOpen = false" class="hover:text-[#dfb15b] text-[#fbf8f1] transition py-2 block">Analisis Baru</a>
                            <a href="javascript:void(0)" onclick="mobileMenuOpen = false; showLoginAlert()" class="hover:text-[#dfb15b] text-[#fbf8f1] transition py-2 block">Latihan Kuis</a>
                            
                            <div class="h-px bg-[#dfb15b]/20 my-2"></div>
                            
                            <div class="flex flex-col space-y-3 mt-4">
                                <a href="{{ route('login') }}" @click="mobileMenuOpen = false" class="w-full text-center px-4 py-3 border-2 border-[#dfb15b] text-[#dfb15b] hover:bg-[#dfb15b] hover:text-[#1b4332] font-bold rounded-xl transition">Masuk Ke Akun</a>
                                <a href="{{ route('register') }}" @click="mobileMenuOpen = false" class="w-full text-center px-4 py-3 bg-[#b45309] hover:bg-[#9a4004] text-white font-bold rounded-xl shadow-md transition">Daftar Sekarang</a>
                            </div>
                        </nav>
                    </div>
                </div>
            @endauth
        </header>

        <!-- Dynamic Main Content Wrapper -->
        <main class="flex-grow p-4 sm:p-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="py-6 text-center border-t border-[#e6dec9] text-xs text-[#5c6f60] bg-[#fbf8f1] flex items-center justify-center gap-1.5">
            <span>&copy; {{ date('Y') }} Smart Nahwu</span>
            <span>•</span>
            <span>v{{ config('app.version') }}</span>
        </footer>
    </div>

    <!-- SweetAlert helper script for Guest Kuis Redirect -->
    <script>
        function showLoginAlert() {
            Swal.fire({
                title: 'Harus Masuk Terlebih Dahulu',
                text: 'Silakan masuk atau mendaftar akun terlebih dahulu untuk memulai latihan kuis agar seluruh progres belajar dan riwayat nilai Anda tersimpan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1b4332',
                cancelButtonColor: '#b45309',
                confirmButtonText: 'Masuk Sekarang',
                cancelButtonText: 'Daftar Akun',
                denyButtonText: 'Batal',
                showDenyButton: true,
                denyButtonColor: '#5c6f60',
                customClass: {
                    popup: 'rounded-3xl border border-[#e6dec9]',
                    confirmButton: 'rounded-xl font-bold px-4 py-2 text-xs',
                    cancelButton: 'rounded-xl font-bold px-4 py-2 text-xs',
                    denyButton: 'rounded-xl font-bold px-4 py-2 text-xs'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = "{{ route('register') }}";
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>
