<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart Nahwu - Asisten Belajar Nahwu & Shorof')</title>
    
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
            border: 1px solid #e2d9c0; /* Single clean thin border */
            box-shadow: 0 2px 4px rgba(27, 67, 50, 0.04); /* Thin, subtle shadow */
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col">

    <!-- Header Navbar -->
    <header class="bg-[#1b4332] border-b-4 border-[#b45309] sticky top-0 z-50 w-full py-4 px-6 flex flex-col sm:flex-row justify-between items-center shadow-md">
        <a href="/" class="flex items-center space-x-2 mb-3 sm:mb-0">
            <span class="text-2xl font-extrabold text-[#fbf8f1] tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-mosque text-[#dfb15b]"></i> Smart Nahwu
            </span>
        </a>
        <nav class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm font-semibold">
            <a href="/analyze" class="hover:text-[#dfb15b] text-[#fbf8f1] transition py-1">Analisis Baru</a>
            <a href="/quiz" class="hover:text-[#dfb15b] text-[#fbf8f1] transition py-1">Latihan Kuis</a>
            
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="/admin" class="hover:text-[#dfb15b] text-[#fbf8f1] transition py-1">Admin Panel</a>
                @endif
                <span class="text-[#dfb15b]/40">|</span>
                <span class="text-[#dfb15b] text-xs bg-[#133827] px-2.5 py-1 rounded border border-[#dfb15b]/30">
                    {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                </span>
                <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                    @csrf
                    <button type="submit" class="hover:text-[#dfb15b] text-[#fbf8f1] transition cursor-pointer py-1">Keluar</button>
                </form>
            @else
                <span class="text-[#dfb15b]/40">|</span>
                <a href="{{ route('login') }}" class="hover:text-[#dfb15b] text-[#fbf8f1] transition py-1">Masuk</a>
                <a href="{{ route('register') }}" class="px-3.5 py-1.5 bg-[#b45309] hover:bg-[#9a4004] text-white rounded shadow transition">Daftar</a>
            @endauth
        </nav>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center border-t border-[#e6dec9] text-sm text-[#5c6f60]">
        &copy; {{ date('Y') }} Smart Nahwu. Dikembangkan dengan nuansa pembelajaran kitab tradisional.
    </footer>

</body>
</html>
