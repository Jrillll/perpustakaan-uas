<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Online</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-[#f1f3f6]">

    <!-- WRAPPER -->
    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-56 bg-white border-r border-gray-200 min-h-screen">

            <!-- LOGO -->
            <div class="bg-[#4f46e5] text-white text-center py-3 text-sm font-semibold border-b">
                Perpustakaan Online
            </div>

            <!-- MENU -->
            <div class="p-4">

                <p class="text-[11px] font-bold text-gray-600 mb-4">
                    Menu
                </p>

                <div class="space-y-3 text-[12px]">

                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-indigo-600">

                        📚
                        <span>Daftar Buku</span>

                    </a>

                    <a href="{{ route('borrowings.index') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-indigo-600">

                        📖
                        <span>Pinjaman Saya</span>

                    </a>

                    <a href="#"
                        class="flex items-center gap-2 text-gray-700 hover:text-indigo-600">

                        🕘
                        <span>Riwayat</span>

                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            class="flex items-center gap-2 text-red-500 hover:text-red-600 text-left text-[12px]">

                            🚪
                            <span>Logout</span>

                        </button>
                    </form>

                </div>

            </div>

        </aside>

        <!-- MAIN -->
        <main class="flex-1">

            <!-- TOPBAR -->
            <div class="bg-[#4f46e5] text-white px-6 py-2 flex justify-end text-[11px]">
                Halo, {{ auth()->user()->name }}
            </div>

            <!-- CONTENT -->
            <div class="p-5">

                <!-- TITLE -->
                <h1 class="text-[20px] font-bold text-gray-800 mb-4">
                    Daftar Buku Tersedia
                </h1>

                <!-- SEARCH -->
                <form
                    method="GET"
                    action="{{ route('dashboard') }}"
                    class="flex mb-5">

                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari buku..."
                        class="flex-1 border border-gray-300 bg-white px-3 py-2 text-[12px] rounded-l outline-none"
                    >

                    <button
                        type="submit"
                        class="bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 text-[12px] rounded-r">

                        Cari

                    </button>

                </form>

                <!-- BOOK LIST -->
                <div class="space-y-3">

                    @foreach($books as $book)

                    <div class="bg-white border border-gray-200 rounded-lg p-4 flex gap-4">

                        <!-- COVER -->
                        <div class="w-20 h-28 bg-gray-100 border rounded overflow-hidden flex-shrink-0">

                            <img
                                src="{{ $book->cover }}"
                                alt="{{ $book->title }}"
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >

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
                                {{ $book->description ?? 'Tidak ada deskripsi tersedia.' }}
                            </p>

                        </div>

                        <!-- BUTTON -->
                        <div class="flex items-start">

                            <a
                                href="{{ route('books.show', $book->id) }}"
                                class="text-[11px] text-indigo-600 hover:underline mt-1">

                                Lihat Selengkapnya

                            </a>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </main>

    </div>

</body>
</html>