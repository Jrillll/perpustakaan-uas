@extends('layouts.app')

@section('title', 'Form Peminjaman')

@section('content')
<div class="max-w-2xl mx-auto py-4">

    <!-- Back Button -->
    <div class="mb-8">
        <a href="{{ route('books.show', $book->id) }}" class="px-4 py-2.5 rounded-xl bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 text-sm font-semibold transition inline-flex items-center gap-2 shadow-sm">
            <span>←</span> Batal
        </a>
    </div>

    <!-- BOOKING FORM CARD -->
    <div class="bg-white border border-gray-200 p-6 md:p-10 rounded-3xl shadow-sm relative">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl"></div>

        <div class="mb-8">
            <h2 class="text-2xl md:text-3xl font-black text-gray-800 mb-2 heading-font">Form Peminjaman Buku</h2>
            <p class="text-gray-500 text-sm">Silakan tentukan jadwal pinjam dan durasi peminjaman buku Anda.</p>
        </div>

        <form method="POST" action="{{ route('books.borrow.submit', $book->id) }}" class="space-y-6">
            @csrf

            <!-- Buku (Disabled) -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Buku Pilihan</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-gray-400">📖</span>
                    <input
                        type="text"
                        value="{{ $book->title }}"
                        readonly
                        class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-gray-100 border border-gray-200 text-gray-500 text-sm focus:outline-none select-none cursor-not-allowed font-medium"
                    >
                </div>
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <label for="tanggal_mulai" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tanggal Mulai Pinjam</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-gray-400">📅</span>
                    <input
                        type="date"
                        id="tanggal_mulai"
                        name="tanggal_mulai"
                        min="{{ date('Y-m-d') }}"
                        value="{{ date('Y-m-d') }}"
                        class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-indigo-500 text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition cursor-pointer"
                        required
                    >
                </div>
            </div>

            <!-- Durasi Peminjaman -->
            <div>
                <label for="durasi" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Durasi Peminjaman</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-gray-400">🕓</span>
                    <select name="durasi" id="durasi" class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-indigo-500 text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition cursor-pointer" required>
                        <option value="">-- Pilih Durasi --</option>
                        <option value="1">1 Hari</option>
                        <option value="2">2 Hari</option>
                        <option value="3">3 Hari</option>
                    </select>
                </div>
            </div>

            <!-- INFO STATUS BANNER -->
            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs leading-relaxed flex items-start gap-2.5 shadow-sm animate-pulse">
                <span class="text-base leading-none">⚠️</span>
                <div>
                    <strong class="font-bold block mb-0.5">Informasi Penting:</strong>
                    Peminjaman buku akan diproses setelah mendapat persetujuan dari Admin. Silakan periksa halaman "Pinjaman Saya" secara berkala setelah mengajukan.
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="flex-1 py-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-md shadow-emerald-600/10 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 text-center">
                    🚀 Kirim Pengajuan Peminjaman
                </button>
                <a href="{{ route('books.show', $book->id) }}" class="px-6 py-4 rounded-xl bg-gray-105 hover:bg-gray-200/80 text-gray-700 text-sm font-semibold border border-gray-200 hover:scale-[1.01] active:scale-[0.99] transition-all text-center">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>
@endsection
