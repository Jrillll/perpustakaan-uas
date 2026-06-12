@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="max-w-4xl mx-auto py-4">

    <!-- Back Button -->
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="px-4 py-2.5 rounded-xl bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 text-sm font-semibold transition inline-flex items-center gap-2 shadow-sm">
            <span>←</span> Kembali ke Daftar Buku
        </a>
    </div>

    <!-- QUICK STATS TILES -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="bg-white border border-gray-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                📚
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Stok Buku</p>
                <p class="text-2xl font-black text-gray-800 heading-font">{{ $total_buku }}</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                📖
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Sedang Dipinjam</p>
                <p class="text-2xl font-black text-gray-800 heading-font">{{ $dipinjam }}</p>
            </div>
        </div>
    </div>

    <!-- BOOK DETAIL HERO CARD -->
    <div class="bg-white border border-gray-200 p-6 md:p-8 rounded-3xl shadow-sm flex flex-col md:flex-row gap-8 mb-8 relative overflow-hidden">
        
        <!-- Cover Image -->
        <div class="w-40 h-56 rounded-2xl overflow-hidden bg-gray-100 shadow-md border border-gray-200 flex-shrink-0 mx-auto md:mx-0">
            <img
                src="{{ $book->cover ? asset('storage/' . $book->cover) : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' }}"
                alt="{{ $book->title }}"
                class="w-full h-full object-cover"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="hidden absolute inset-0 bg-gray-200 flex flex-col items-center justify-center p-4 text-center text-gray-400">
                <span class="text-4xl mb-2">📖</span>
                <span class="text-xs font-bold uppercase tracking-wider">No Cover</span>
            </div>
        </div>

        <!-- Info details -->
        <div class="flex-1 flex flex-col justify-between text-center md:text-left">
            <div class="space-y-4">
                <div>
                    <h2 class="text-2xl md:text-3.5xl font-black text-gray-800 heading-font leading-tight">{{ $book->title }}</h2>
                </div>

                <div class="flex flex-wrap justify-center md:justify-start gap-x-6 gap-y-2 text-sm text-gray-500">
                    <p>Penulis: <strong class="text-gray-700 font-semibold">{{ $book->author }}</strong></p>
                    <p>Penerbit: <strong class="text-gray-700 font-semibold">{{ $book->publisher ?? '-' }}</strong></p>
                    <p>Tahun: <strong class="text-gray-700 font-semibold">{{ $book->publication_year ?? '-' }}</strong></p>
                </div>

                <div class="flex justify-center md:justify-start items-center gap-2">
                    <!-- Rating displays -->
                    <div class="text-yellow-500 text-lg tracking-tight">
                        @php
                            $rating = round($book->dynamic_rating);
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $rating ? '★' : '☆' }}
                        @endfor
                    </div>
                    <span class="text-xs font-bold text-gray-500">({{ number_format($book->dynamic_rating, 1) }} / 5.0)</span>
                </div>

                <hr class="border-gray-200">

                <div class="space-y-2">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sinopsis / Deskripsi</h4>
                    <p class="text-gray-600 text-sm leading-relaxed text-justify md:text-left">
                        {{ $book->description ?? 'Tidak ada deskripsi tersedia untuk buku ini.' }}
                    </p>
                </div>
            </div>

            <!-- Borrow Button Action -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-left">
                    <p class="text-xs text-gray-400">Ketersediaan Stok</p>
                    <p class="text-sm font-semibold text-gray-600">
                        Stok:
                        <span class="{{ $book->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }} font-bold">
                            {{ $book->stock > 0 ? $book->stock . ' Buku Tersedia' : 'Habis' }}
                        </span>
                    </p>
                </div>

                @if($book->stock > 0)
                    <a href="{{ route('books.borrow', $book->id) }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-md shadow-emerald-600/10 hover:scale-[1.02] active:scale-95 transition-all duration-200 text-center">
                        ⚡ Ajukan Pinjam Buku
                    </a>
                @else
                    <button disabled class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-gray-100 border border-gray-200 text-gray-400 font-bold text-sm cursor-not-allowed text-center">
                        ❌ Stok Buku Habis
                    </button>
                @endif
            </div>

        </div>
    </div>

    <!-- FORM: RATINGS & COMMENTS -->
    <div class="bg-white border border-gray-200 p-6 md:p-8 rounded-3xl shadow-sm mb-8">
        <h3 class="font-bold text-lg text-gray-800 mb-4 heading-font flex items-center gap-2">
            <span>⭐</span> Beri Rating & Komentar
        </h3>

        <form method="POST" action="{{ route('books.review', $book->id) }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <label for="rating" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Pilih Rating</label>
                    <select name="rating" id="rating" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-indigo-500 text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition cursor-pointer" required>
                        <option value="">-- Pilih Rating --</option>
                        <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                        <option value="4">⭐⭐⭐⭐ (4)</option>
                        <option value="3">⭐⭐⭐ (3)</option>
                        <option value="2">⭐⭐ (2)</option>
                        <option value="1">⭐ (1)</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label for="komentar" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Komentar / Ulasan</label>
                    <input
                        type="text"
                        id="komentar"
                        name="komentar"
                        placeholder="Tulis komentar ulasan buku..."
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-indigo-500 text-gray-850 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-sm transition"
                        required
                    >
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shadow-md shadow-indigo-600/10 transition active:scale-95">
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>

    <!-- LIST: COMMENTS SECTION -->
    <div class="bg-white border border-gray-200 p-6 md:p-8 rounded-3xl shadow-sm">
        <h3 class="font-bold text-lg text-gray-800 mb-6 heading-font flex items-center gap-2">
            <span>💬</span> Komentar Pembaca ({{ $reviews->count() }})
        </h3>

        @if($reviews->isEmpty())
            <div class="py-8 text-center text-gray-400 text-sm">
                Belum ada komentar pembaca. Jadilah yang pertama memberikan ulasan!
            </div>
        @else
            <div class="divide-y divide-gray-100 space-y-5">
                @foreach($reviews as $k)
                    <div class="pt-5 first:pt-0">
                        <div class="flex items-center justify-between gap-4 mb-2">
                            <span class="font-semibold text-indigo-600 text-sm">{{ $k->user->name ?? 'User' }}</span>
                            <small class="text-xs text-gray-450">{{ $k->created_at ? $k->created_at->diffForHumans() : '-' }}</small>
                        </div>

                        <!-- User Rating Stars -->
                        <div class="text-yellow-500 text-xs tracking-tight mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                {{ $i <= $k->rating ? '★' : '☆' }}
                            @endfor
                        </div>

                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $k->comment }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
