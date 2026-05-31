<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Online</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-[#f3f4f6] overflow-hidden">

    <!-- HEADER -->
    <header class="w-full bg-[#4f46e5] h-10 flex items-center justify-between px-4 text-white text-[11px] shadow">

        <!-- LEFT -->
        <div class="font-semibold">
            Perpustakaan Online
        </div>

        <!-- RIGHT -->
        <div>
            Halo, {{ auth()->user()->name }}
        </div>

    </header>

    <!-- MAIN LAYOUT -->
    <div class="flex">

        <!-- SIDEBAR -->
        <aside class="w-56 bg-white border-r border-gray-200 min-h-screen">

            <div class="p-4">

                <!-- MENU TITLE -->
                <p class="text-[11px] font-bold text-gray-600 mb-4">
                    Menu
                </p>

                <!-- MENU -->
                <div class="space-y-4 text-[12px]">

                    <!-- DASHBOARD -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-indigo-600 transition">

                        📚
                        <span>Daftar Buku</span>

                    </a>

                    <!-- BORROW -->
                    <a href="{{ route('borrowings.index') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-indigo-600 transition">

                        📖
                        <span>Pinjaman Saya</span>

                    </a>

                    <!-- HISTORY -->
                 <a href="{{ route('borrowings.history') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-indigo-600 transition">

                        🕘
                        <span>Riwayat</span>

                    </a>

                    <!-- LOGOUT -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            class="flex items-center gap-2 text-red-500 hover:text-red-600 transition text-[12px]">

                            🚪
                            <span>Logout</span>

                        </button>
                    </form>

                </div>

            </div>

        </aside>

        <!-- CONTENT -->
        <main class="flex-1 h-[calc(100vh-40px)] overflow-y-auto">

            <div class="p-5">

                <!-- NOTIFICATIONS -->
                @if(session('success'))
                    <div class="bg-emerald-100 border border-emerald-200 text-emerald-800 p-4 rounded-xl mb-5 text-[12px] flex items-center justify-between shadow-sm">
                        <span class="font-medium flex items-center gap-2">
                            <span>✓</span> {{ session('success') }}
                        </span>
                        <button onclick="this.parentElement.remove()" class="text-emerald-850 hover:text-emerald-955 font-bold ml-2 text-sm leading-none">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-rose-100 border border-rose-200 text-rose-800 p-4 rounded-xl mb-5 text-[12px] flex items-center justify-between shadow-sm">
                        <span class="font-medium flex items-center gap-2">
                            <span>✗</span> {{ session('error') }}
                        </span>
                        <button onclick="this.parentElement.remove()" class="text-rose-850 hover:text-rose-955 font-bold ml-2 text-sm leading-none">&times;</button>
                    </div>
                @endif

                <!-- TITLE -->
                <h1 class="text-[20px] font-bold text-gray-800 mb-4">
                    Daftar Buku Tersedia
                </h1>

                <!-- SEARCH -->
                <form
                    method="GET"
                    action="{{ route('dashboard') }}"
                    class="flex mb-4">

                    @if($genre)
                        <input type="hidden" name="genre" value="{{ $genre }}">
                    @endif

                    <!-- INPUT -->
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari buku..."
                        class="flex-1 border border-gray-300 bg-white px-3 py-2 text-[12px] rounded-l outline-none focus:ring-1 focus:ring-indigo-500"
                    >

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        class="bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 text-[12px] rounded-r transition">

                        Cari

                    </button>

                </form>

                <!-- GENRE FILTER -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <a href="{{ route('dashboard', array_filter(['search' => $search])) }}" 
                       class="px-3.5 py-1.5 rounded-full text-[11px] font-semibold transition-all duration-200 shadow-sm border {{ !$genre ? 'bg-[#4f46e5] text-white border-[#4f46e5] scale-[1.02]' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                        Semua Genre
                    </a>
                    @foreach($genres as $g)
                        <a href="{{ route('dashboard', array_filter(['genre' => $g, 'search' => $search])) }}" 
                           class="px-3.5 py-1.5 rounded-full text-[11px] font-semibold transition-all duration-200 shadow-sm border {{ $genre === $g ? 'bg-[#4f46e5] text-white border-[#4f46e5] scale-[1.02]' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                            {{ $g }}
                        </a>
                    @endforeach
                </div>

                <!-- RECOMMENDED SECTION -->
                @if($recommendedBooks && $recommendedBooks->isNotEmpty() && !$genre && !$search)
                    <div class="mb-8">
                        <h2 class="text-[14px] font-bold text-gray-800 mb-3 flex items-center gap-1.5 heading-font">
                            <span></span> Rekomendasi Buku
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($recommendedBooks as $recBook)
                                <div class="bg-white border border-gray-200 rounded-2xl p-4 flex flex-col justify-between hover:shadow-md transition duration-200 relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/5 rounded-full blur-xl pointer-events-none"></div>
                                    
                                    <div class="flex gap-3.5">
                                        <!-- Cover -->
                                        <div class="w-16 h-24 bg-gray-50 border rounded-lg overflow-hidden flex-shrink-0 shadow-sm">
                                            <img
                                                src="{{ $recBook->cover }}"
                                                alt="{{ $recBook->title }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                            >
                                            <div class="hidden w-full h-full items-center justify-center text-gray-400 text-[9px]">
                                                No Cover
                                            </div>
                                        </div>
                                        
                                        <!-- Details -->
                                        <div class="flex-1 min-w-0">
                                            <span class="inline-block bg-indigo-50 text-[#4f46e5] px-2 py-0.5 rounded-md text-[9px] font-bold mb-1.5 uppercase tracking-wider">
                                                {{ $recBook->genre ?? 'Umum' }}
                                            </span>
                                            <h3 class="text-[12px] font-bold text-gray-850 truncate group-hover:text-[#4f46e5] transition duration-200 mb-0.5" title="{{ $recBook->title }}">
                                                {{ $recBook->title }}
                                            </h3>
                                            <p class="text-[10px] text-gray-500 mb-1 truncate">
                                                {{ $recBook->author }}
                                            </p>
                                            <div class="text-yellow-500 text-[10px]">
                                                @php
                                                    $recRating = round($recBook->dynamic_rating);
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $recRating ? '★' : '☆' }}
                                                @endfor
                                                <span class="text-gray-400 text-[9px] ml-1 font-bold">({{ number_format($recBook->dynamic_rating, 1) }})</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Action -->
                                    <div class="mt-3.5 pt-3 border-t border-gray-100 flex items-center justify-between">
                                        <span class="text-[10px] text-gray-500 font-medium">Stok: <strong class="{{ $recBook->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $recBook->stock }}</strong></span>
                                        <a href="{{ route('books.show', $recBook->id) }}" class="text-[10px] bg-[#4f46e5] hover:bg-[#4338ca] text-white px-3 py-1.5 rounded-lg font-bold transition shadow-sm">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- EMPTY -->
                @if($books->isEmpty())

                    <div class="bg-white border rounded-lg p-10 text-center">

                        <div class="text-4xl mb-3">
                            📚
                        </div>

                        <h2 class="text-[18px] font-semibold text-gray-700 mb-2">
                            Buku tidak ditemukan
                        </h2>

                        <p class="text-gray-500 text-[12px]">
                            Tidak ada buku yang cocok dengan pencarian "{{ $search }}"
                        </p>

                    </div>

                @else

                <!-- BOOK LIST -->
                <div class="space-y-3">

                    @foreach($books as $book)

                    <div class="bg-white border border-gray-200 rounded-lg p-4 flex gap-4 hover:shadow-sm transition">

                        <!-- COVER -->
                        <div class="w-20 h-28 bg-gray-100 border rounded overflow-hidden flex-shrink-0">

                            <img
                                src="{{ $book->cover }}"
                                alt="{{ $book->title }}"
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >

                            <!-- FALLBACK -->
                            <div class="hidden w-full h-full items-center justify-center text-gray-400 text-[10px]">
                                No Cover
                            </div>

                        </div>

                        <!-- INFO -->
                        <div class="flex-1">

                            <!-- TITLE -->
                            <h2 class="text-[15px] font-bold text-gray-800 mb-1">
                                {{ $book->title }}
                            </h2>

                            <!-- GENRE BADGE -->
                            @if($book->genre)
                            <div class="mb-1.5">
                                <span class="inline-block bg-indigo-50 text-[#4f46e5] px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider">
                                    {{ $book->genre }}
                                </span>
                            </div>
                            @endif

                            <!-- AUTHOR -->
                            <p class="text-[11px] text-gray-600">
                                Penulis: {{ $book->author }}
                            </p>

                            <!-- PUBLISHER -->
                            <p class="text-[11px] text-gray-600 mb-2">
                                Penerbit: {{ $book->publisher ?? '-' }}
                            </p>

                            <!-- RATING -->
                            <div class="text-yellow-500 text-[12px] mb-2">

                                @php
                                    $rating = round($book->dynamic_rating);
                                @endphp

                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= $rating ? '★' : '☆' }}
                                @endfor

                            </div>

                            <!-- DESC -->
                            <p class="text-[11px] text-gray-500 leading-relaxed">
                                {{ $book->description ?? 'Tidak ada deskripsi tersedia untuk buku ini.' }}
                            </p>

                        </div>

                        <!-- ACTION -->
                        <div class="flex items-start">

                            <a
                                href="{{ route('books.show', $book->id) }}"
                                class="text-[11px] text-indigo-600 hover:underline mt-1 whitespace-nowrap">

                                Lihat Selengkapnya

                            </a>

                        </div>

                    </div>

                    @endforeach

                </div>

                @endif

            </div>

        </main>

    </div>

</body>
</html>