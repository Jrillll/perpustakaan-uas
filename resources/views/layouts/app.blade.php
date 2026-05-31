<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan') - Perpustakaan Online</title>

    <!-- Google Fonts for Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind & Vite Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js (used in about.blade.php tabs) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f3f4f6; /* Dashboard Light Gray background */
        }
        .heading-font {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="text-gray-700 min-h-screen flex flex-col selection:bg-indigo-500/20 selection:text-indigo-900">

    <!-- Premium Navbar matching Dashboard -->
    <header class="w-full bg-[#4f46e5] shadow-md sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between text-white">
            <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                <span class="text-xl">📚</span>
                <span class="font-bold tracking-tight heading-font text-sm md:text-base">Perpustakaan <span class="text-indigo-200">Online</span></span>
            </a>

            <!-- Navigation Links -->
            <nav class="flex items-center gap-5 text-[12px] font-medium">
                <a href="{{ url('/') }}" class="text-indigo-100 hover:text-white transition">Beranda</a>
                <a href="{{ route('about') }}" class="text-indigo-100 hover:text-white transition">Tentang</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="px-3.5 py-1.5 rounded bg-white text-[#4f46e5] font-semibold hover:bg-indigo-50 transition shadow-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-indigo-100 hover:text-white transition">Masuk</a>
                    <a href="{{ route('register') }}" class="px-3.5 py-1.5 rounded bg-white text-[#4f46e5] font-semibold hover:bg-indigo-50 transition shadow-sm">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 py-8 px-4 max-w-6xl mx-auto w-full">
        @if(session('success'))
            <div class="max-w-4xl mx-auto mb-6 bg-emerald-100 border border-emerald-200 text-emerald-800 p-4 rounded-xl flex items-center gap-3 text-sm shadow-sm">
                <span>✓</span> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-4xl mx-auto mb-6 bg-rose-100 border border-rose-200 text-rose-800 p-4 rounded-xl flex items-center gap-3 text-sm shadow-sm">
                <span>✗</span> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-gray-200 bg-white py-6 text-center text-xs text-gray-500">
        <p>&copy; {{ date('Y') }} Perpustakaan Online. All rights reserved.</p>
    </footer>

</body>
</html>
