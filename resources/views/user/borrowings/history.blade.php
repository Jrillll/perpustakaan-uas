<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>

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

    <!-- MAIN -->
    <div class="flex">

        <!-- SIDEBAR -->
        <aside class="w-56 bg-white border-r border-gray-200 min-h-screen">

            <div class="p-4">

                <!-- MENU -->
                <p class="text-[11px] font-bold text-gray-600 mb-4">
                    Menu
                </p>

                <div class="space-y-4 text-[12px]">

                    <!-- DASHBOARD -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-indigo-600 transition">

                        📚
                        <span>Daftar Buku</span>

                    </a>

                    <!-- BORROWINGS -->
                    <a href="{{ route('borrowings.index') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-indigo-600 transition">

                        📖
                        <span>Pinjaman Saya</span>

                    </a>

                    <!-- HISTORY -->
                    <a href="{{ route('borrowings.history') }}"
                        class="flex items-center gap-2 text-indigo-600 font-semibold">

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

                <!-- HEADER -->
                <div class="flex items-center justify-between mb-5">

                    <div>

                        <h1 class="text-[20px] font-bold text-gray-800 mb-1">
                            Riwayat Peminjaman
                        </h1>

                        <p class="text-[12px] text-gray-500">
                            Daftar buku yang telah selesai Anda pinjam dan kembalikan.
                        </p>

                    </div>

                    <!-- BUTTON -->
                    <a href="{{ route('dashboard') }}"
                        class="bg-[#4f46e5] hover:bg-[#4338ca] text-white px-4 py-2 rounded text-[11px] transition">

                        ← Daftar Buku

                    </a>

                </div>

                <!-- EMPTY -->
                @if($data->isEmpty())

                    <div class="bg-white border border-gray-200 rounded-lg p-10 text-center">

                        <div class="text-4xl mb-3">
                            🕘
                        </div>

                        <h2 class="text-[18px] font-semibold text-gray-700 mb-2">
                            Belum Ada Riwayat
                        </h2>

                        <p class="text-[12px] text-gray-500">
                            Anda belum memiliki riwayat pengembalian buku.
                        </p>

                    </div>

                @else

                <!-- LIST -->
                <div class="space-y-3">

                    @foreach($data as $d)

                    <!-- CARD -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 flex gap-4 hover:shadow-sm transition">

                        <!-- COVER -->
                        <div class="w-20 h-28 bg-gray-100 border rounded overflow-hidden flex-shrink-0">

                            <img
                                src="{{ $d->book->cover }}"
                                alt="{{ $d->book->title }}"
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
                                {{ $d->book->title }}
                            </h2>

                            <!-- AUTHOR -->
                            <p class="text-[11px] text-gray-600 mb-3">
                                Penulis:
                                <span class="font-medium">
                                    {{ $d->book->author }}
                                </span>
                            </p>

                            <!-- DATE BOX -->
                            <div class="flex flex-wrap gap-3 mb-3">

                                <!-- BORROW DATE -->
                                <div class="bg-gray-100 px-3 py-2 rounded text-[11px]">

                                    <p class="text-gray-500 mb-1">
                                        Tanggal Pinjam
                                    </p>

                                    <p class="font-semibold text-gray-700">
                                        {{ $d->borrow_date ? date('d M Y', strtotime($d->borrow_date)) : '-' }}
                                    </p>

                                </div>

                                <!-- RETURN DATE -->
                                <div class="bg-gray-100 px-3 py-2 rounded text-[11px]">

                                    <p class="text-gray-500 mb-1">
                                        Tanggal Kembali
                                    </p>

                                    <p class="font-semibold text-gray-700">
                                        {{ $d->return_date ? date('d M Y', strtotime($d->return_date)) : '-' }}
                                    </p>

                                </div>

                            </div>

                            <!-- STATUS -->
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded text-[10px] font-semibold">

                                ✔ Selesai Dikembalikan

                            </span>

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