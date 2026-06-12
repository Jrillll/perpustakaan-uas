@extends('layouts.app')

@section('title', 'Pinjaman Saya')

@section('content')
<div class="max-w-4xl mx-auto py-4">
    
    <!-- Header -->
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h2 class="text-2xl md:text-4xl font-extrabold text-white heading-font tracking-tight mb-2">Buku yang Sedang Dipinjam</h2>
            <p class="text-slate-400 text-sm">Daftar buku perpustakaan yang aktif Anda pinjam saat ini.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-900/50 hover:bg-slate-800 border border-slate-800 text-sm font-semibold transition flex items-center gap-2">
            <span>←</span> Daftar Buku
        </a>
    </div>

    <!-- BORROWINGS LIST -->
    @if($data->isEmpty())
        <div class="bg-slate-900/40 border border-slate-800 rounded-3xl p-16 text-center shadow-xl">
            <span class="text-5xl block mb-4">📖</span>
            <h3 class="text-lg font-bold text-slate-300 heading-font mb-2">Belum Ada Buku Dipinjam</h3>
            <p class="text-slate-500 text-sm max-w-sm mx-auto">Anda tidak sedang meminjam buku apa pun saat ini. Silakan cari buku di katalog untuk diajukan!</p>
            <a href="{{ route('dashboard') }}" class="inline-block mt-6 px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm shadow-xl shadow-indigo-600/10">Mulai Membaca 📚</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($data as $d)
                <!-- Card changes background gracefully when overdue (telat) -->
                <div class="relative overflow-hidden group p-5 rounded-3xl shadow-xl transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-start gap-6 border {{ $d->telat ? 'bg-red-500/10 border-red-500/20 shadow-red-500/2' : 'bg-slate-900/40 border-slate-800' }}">
                    
                    <!-- Decorative warning strip for overdue borrowings -->
                    @if($d->telat)
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-500"></div>
                    @endif

                    <!-- Cover image -->
                    <div class="w-24 h-36 rounded-2xl overflow-hidden bg-slate-800 border border-slate-850 shadow-md flex-shrink-0">
                        <img 
                            src="{{ $d->book->cover }}" 
                            alt="{{ $d->book->title }}" 
                            class="w-full h-full object-cover"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="hidden absolute inset-0 bg-slate-850 flex flex-col items-center justify-center p-3 text-center text-slate-500">
                            <span class="text-xl mb-1">📖</span>
                            <span class="text-[8px] font-bold uppercase tracking-wider leading-none">No Cover</span>
                        </div>
                    </div>

                    <!-- Details information -->
                    <div class="flex-1 flex flex-col justify-between self-stretch text-center sm:text-left py-1">
                        <div>
                            <h3 class="font-bold text-xl text-white heading-font mb-1 group-hover:text-indigo-400 transition leading-snug">{{ $d->book->title }}</h3>
                            <p class="text-xs text-slate-400 mb-3">Penulis: <span class="text-slate-300 font-medium">{{ $d->book->author }}</span></p>
                            
                            <p class="text-xs text-slate-400">Tanggal Pengembalian: 
                                <strong class="text-slate-200">
                                    {{ $d->due_date ? date('d M Y', strtotime($d->due_date)) : '-' }}
                                </strong>
                            </p>
                        </div>

                        <!-- Status badge row -->
                        <div class="mt-4 flex flex-wrap items-center justify-center sm:justify-start gap-3">
                            @if($d->telat)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-red-500/10 text-red-400 border border-red-500/15 uppercase tracking-wide">
                                    ⚠️ Telat {{ $d->hari_telat }} Hari
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/15">
                                    Denda: Rp {{ number_format($d->denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/15 uppercase tracking-wide">
                                    ✔ Tepat Waktu
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Return button form -->
                    <div class="flex items-center sm:self-center">
                        <form action="{{ route('borrowings.return', $d->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?');">
                            @csrf
                            <button type="submit" class="px-5 py-3 rounded-xl bg-red-600 hover:bg-red-500 text-white text-xs font-bold shadow-lg shadow-red-600/10 transition active:scale-95 whitespace-nowrap">
                                Kembalikan Buku
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
