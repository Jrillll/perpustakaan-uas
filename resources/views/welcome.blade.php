@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="min-h-[70vh] flex flex-col justify-center items-center text-center px-4 py-12 relative">
    
    <div class="relative max-w-3xl bg-white p-10 md:p-16 rounded-3xl border border-gray-200/80 shadow-md flex flex-col items-center">
        
        <!-- Premium Tag -->
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600 border border-indigo-100 mb-6 heading-font tracking-wide uppercase">
            🚀 Sistem Informasi Perpustakaan
        </span>

        <!-- Hero Title -->
        <h1 class="text-4xl md:text-6xl font-black tracking-tight text-gray-800 mb-6 heading-font leading-tight bg-gradient-to-r from-gray-850 via-gray-900 to-indigo-700 bg-clip-text text-transparent">
            Perpustakaan Digital
        </h1>
        
        <h2 class="text-xl md:text-2xl font-medium text-gray-750 mb-6 font-sans">
            Sistem Peminjaman Buku Praktis
        </h2>

        <!-- Description -->
        <p class="text-gray-500 max-w-xl mb-10 text-base leading-relaxed">
            Platform modern untuk membantu mahasiswa melakukan pencarian, peninjauan ulasan, dan pengajuan peminjaman buku dengan lebih cepat dan praktis.
        </p>

        <!-- Dynamic Landing Actions -->
        @guest
            <div class="flex flex-col sm:flex-row gap-4 w-full justify-center">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-base shadow-lg shadow-indigo-600/10 hover:scale-[1.02] active:scale-95 transition-all duration-200">
                    Jelajah Buku Sekarang
                </a>
                <a href="{{ route('about') }}" class="px-8 py-4 rounded-2xl bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 hover:scale-[1.02] active:scale-95 transition-all duration-200 font-semibold">
                    Profil Pengembang
                </a>
            </div>
        @else
            <div class="flex gap-4">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:opacity-95 text-white font-bold shadow-lg shadow-indigo-500/10 hover:scale-[1.02] active:scale-95 transition-all duration-200">
                        Masuk Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:opacity-95 text-white font-bold shadow-lg shadow-indigo-500/10 hover:scale-[1.02] active:scale-95 transition-all duration-200">
                        Mulai Jelajah Buku 📚
                    </a>
                @endif
            </div>
        @endguest

    </div>
</div>
@endsection
