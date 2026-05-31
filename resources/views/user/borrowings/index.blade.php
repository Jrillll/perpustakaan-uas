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
                        class="flex items-center gap-2 text-indigo-600 font-semibold">

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

                <!-- HEADER -->
                <div class="flex items-center justify-between mb-5">

                    <div>

                        <h1 class="text-[20px] font-bold text-gray-800 mb-1">
                            Pinjaman Saya
                        </h1>

                        <p class="text-[12px] text-gray-500">
                            Daftar buku yang sedang Anda pinjam saat ini.
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

                        <p class="text-[12px] text-gray-500 mb-5">
                            Anda belum memiliki riwayat peminjaman buku.
                        </p>

                        <a href="{{ route('dashboard') }}"
                            class="bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 py-2 rounded text-[12px] transition">

                            Mulai Membaca 📚

                        </a>

                    </div>

                @else

                <!-- LIST -->
                <div class="space-y-3">

                    @foreach($data as $item)

                    <!-- CARD -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 flex gap-4 hover:shadow-sm transition">

                        <!-- COVER -->
                        <div class="w-20 h-28 bg-gray-100 border rounded overflow-hidden flex-shrink-0">

                            <img
                                src="{{ $item->book->cover }}"
                                alt="{{ $item->book->title }}"
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
                                {{ $item->book->title }}
                            </h2>

                            <!-- AUTHOR -->
                            <p class="text-[11px] text-gray-600 mb-1">
                                Penulis:
                                <span class="font-medium">
                                    {{ $item->book->author }}
                                </span>
                            </p>

                            <!-- BORROW DATE -->
                            <p class="text-[11px] text-gray-600 mb-1">
                                Tanggal Pinjam:
                                <span class="font-semibold">
                                    {{ $item->borrow_date ? date('d M Y', strtotime($item->borrow_date)) : '-' }}
                                </span>
                            </p>

                            <!-- RETURN DATE -->
                            <p class="text-[11px] text-gray-600 mb-3">
                                Tanggal Kembali:
                                <span class="font-semibold">
                                    {{ $item->return_date ? date('d M Y', strtotime($item->return_date)) : '-' }}
                                </span>
                            </p>

                            <!-- STATUS & FINES -->
                            <div class="flex flex-col gap-2 mt-2">
                                <div class="flex flex-wrap gap-2">
                                    @if($item->status === 'pending')
                                        <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-[10px] font-semibold">
                                            ⏳ Menunggu Persetujuan Admin
                                        </span>
                                    @elseif($item->status === 'approved')
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-[10px] font-semibold">
                                            📖 Sedang Dipinjam
                                        </span>
                                    @elseif($item->status === 'rejected')
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-[10px] font-semibold">
                                            ❌ Pengajuan Ditolak
                                        </span>
                                    @elseif($item->status === 'returned')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-[10px] font-semibold">
                                            ✔ Sudah Dikembalikan
                                        </span>
                                    @endif
                                </div>

                                @if(isset($item->telat) && $item->telat)
                                    <div class="bg-red-50 text-red-700 border border-red-100 rounded p-2 text-[10px] max-w-sm mt-1">
                                        ⚠️ <strong>Terlambat {{ $item->hari_telat }} Hari</strong><br>
                                        Denda: <span class="font-bold">Rp {{ number_format($item->denda, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <!-- ACTION -->
                        @if($item->status === 'approved')
                        <div class="flex items-center justify-end flex-shrink-0">
                            <form method="POST" action="{{ route('borrowings.return', $item->id) }}">
                                @csrf
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-[11px] px-3.5 py-2 rounded font-semibold transition active:scale-95">
                                    Kembalikan
                                </button>
                            </form>
                        </div>
                        @endif

                    </div>

                    @endforeach

                </div>

                @endif

            </div>

        </main>

    </div>

</body>
</html>