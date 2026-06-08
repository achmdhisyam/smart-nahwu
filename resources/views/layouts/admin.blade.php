<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Smart Nahwu')</title>
    
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

    <!-- Sidebar Wrapper -->
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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                <span class="text-xl font-extrabold text-[#fbf8f1] tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-mosque text-[#dfb15b] text-2xl"></i>
                    <span>Smart Admin</span>
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
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <span class="block text-xs text-[#dfb15b] font-bold tracking-wider uppercase">Administrator</span>
                <span class="block text-sm font-semibold truncate text-white" title="{{ auth()->user()->name ?? 'Admin' }}">{{ auth()->user()->name ?? 'Admin' }}</span>
            </div>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <!-- Dashboard Link -->
            <a 
                href="{{ route('admin.dashboard') }}" 
                class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('admin.dashboard') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
            >
                <i class="fa-solid fa-gauge-high mr-3.5 text-base {{ request()->routeIs('admin.dashboard') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                Dashboard Admin
            </a>

            <!-- Kelola Bab Link -->
            <a 
                href="{{ route('admin.bab.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('admin.bab.*') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
            >
                <i class="fa-solid fa-book-open mr-3.5 text-base {{ request()->routeIs('admin.bab.*') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                Kelola Bab Jurumiyah
            </a>

            <!-- Kelola Kaidah Link -->
            <a 
                href="{{ route('admin.kaidah.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('admin.kaidah.*') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
            >
                <i class="fa-solid fa-scroll mr-3.5 text-base {{ request()->routeIs('admin.kaidah.*') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                Kelola Kaidah
            </a>

            <!-- Kelola Contoh Kalimat Link -->
            <a 
                href="{{ route('admin.contoh.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('admin.contoh.*') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
            >
                <i class="fa-solid fa-pen-nib mr-3.5 text-base {{ request()->routeIs('admin.contoh.*') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                Kelola Contoh Kalimat
            </a>

            <!-- Kelola Pengguna Link -->
            <a 
                href="{{ route('admin.pengguna.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('admin.pengguna.*') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
            >
                <i class="fa-solid fa-users-gear mr-3.5 text-base {{ request()->routeIs('admin.pengguna.*') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                Kelola Pengguna
            </a>

            <!-- Pengaturan Profil Link -->
            <a 
                href="{{ route('profil.edit', ['layout' => 'admin']) }}" 
                class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('profil.edit') && request()->get('layout') === 'admin' ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
            >
                <i class="fa-solid fa-user-gear mr-3.5 text-base {{ request()->routeIs('profil.edit') && request()->get('layout') === 'admin' ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                Pengaturan Profil
            </a>

            <div class="h-px bg-[#dfb15b]/20 my-4"></div>

            <span class="block px-4 mb-2 text-[10px] font-bold uppercase tracking-wider text-[#dfb15b]/50">Log & Monitoring</span>

            <!-- Log Analisis Kalimat Link -->
            <a 
                href="{{ route('admin.analyses.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('admin.analyses.index') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
            >
                <i class="fa-solid fa-file-waveform mr-3.5 text-base {{ request()->routeIs('admin.analyses.index') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                Log Analisis Kalimat
            </a>

            <!-- Log Ujian Kuis Link -->
            <a 
                href="{{ route('admin.quizzes.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ request()->routeIs('admin.quizzes.index') ? 'bg-[#dfb15b] text-[#1b4332] shadow-md' : 'text-[#fbf8f1] hover:bg-[#173b2c] hover:text-[#dfb15b]' }}"
            >
                <i class="fa-solid fa-graduation-cap mr-3.5 text-base {{ request()->routeIs('admin.quizzes.index') ? 'text-[#1b4332]' : 'text-[#dfb15b] group-hover:text-white' }} transition-colors"></i>
                Log Percobaan Kuis
            </a>
        </nav>

        <!-- Sidebar Footer Actions -->
        <div class="p-4 border-t border-[#dfb15b]/10 bg-[#133225] space-y-2">
            <a href="/" class="flex items-center justify-center w-full px-4 py-2 text-xs font-bold text-white bg-[#b45309] hover:bg-[#9a4004] rounded-lg transition shadow-sm gap-2">
                <i class="fa-solid fa-house"></i>
                <span>Kembali Ke Situs Utama</span>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                @csrf
                <button type="submit" class="flex items-center justify-center w-full px-4 py-2 text-xs font-bold text-white bg-transparent hover:bg-rose-900 border border-white/20 hover:border-rose-900 rounded-lg transition gap-2 cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- Top Navigation Bar -->
        <header class="bg-[#1b4332] border-b-4 border-[#b45309] h-20 px-6 flex items-center justify-between shadow-md sticky top-0 z-30">
            <!-- Mobile Toggle Button -->
            <button 
                @click="sidebarOpen = !sidebarOpen" 
                class="text-[#fbf8f1] hover:text-[#dfb15b] p-2 focus:outline-none transition mr-4"
            >
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            <!-- Brand Info / Dynamic Title -->
            <div class="hidden sm:flex items-center space-x-2">
                <span class="text-sm font-semibold text-[#dfb15b] uppercase tracking-wider">Smart Nahwu Admin Area</span>
            </div>

            <!-- Header Profile Actions -->
            <div class="flex items-center space-x-4">
                <span class="text-xs text-[#fbf8f1] font-semibold hidden md:inline-block">Masuk sebagai: <strong>{{ auth()->user()->name ?? 'Admin' }}</strong></span>
                
                <a href="{{ route('profil.edit', ['layout' => 'admin']) }}" class="w-9 h-9 rounded-full bg-[#dfb15b] hover:bg-white text-[#1b4332] font-bold border border-[#dfb15b]/30 flex items-center justify-center transition shadow-md" title="Pengaturan Profil">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </a>
            </div>
        </header>

        <!-- Dynamic Main Content Wrapper -->
        <main class="flex-grow p-4 sm:p-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="py-6 text-center border-t border-[#e6dec9] text-xs text-[#5c6f60] bg-[#fbf8f1]">
            &copy; {{ date('Y') }} Smart Nahwu Admin. Panel kontrol administrasi pembelajaran Jurumiyah.
        </footer>
    </div>

</body>
</html>
