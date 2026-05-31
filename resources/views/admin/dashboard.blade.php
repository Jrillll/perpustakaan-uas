@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="py-4">
    
    <!-- Dashboard Header -->
    <div class="mb-10">
        <h2 class="text-2xl md:text-4xl font-extrabold text-white heading-font tracking-tight mb-2">Dashboard Administrator</h2>
        <p class="text-slate-400 text-sm">Kelola pengajuan peminjaman buku perpustakaan, setujui/tolak permohonan anggota, dan lihat metrik operasional.</p>
    </div>

    <!-- STATS TILES -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-10">
        
        <div class="bg-slate-900/40 border border-slate-800/80 p-5 rounded-2xl shadow-xl">
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Total Buku</p>
            <p class="text-3xl font-black text-white heading-font">{{ $stats['total_books'] }}</p>
        </div>

        <div class="bg-slate-900/40 border border-slate-800/80 p-5 rounded-2xl shadow-xl">
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Total Anggota</p>
            <p class="text-3xl font-black text-white heading-font">{{ $stats['total_users'] }}</p>
        </div>

        <div class="bg-slate-900/40 border border-slate-800/80 p-5 rounded-2xl shadow-xl">
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Pengajuan Pending</p>
            <p class="text-3xl font-black text-amber-400 heading-font">{{ $stats['pending_requests'] }}</p>
        </div>

        <div class="bg-slate-900/40 border border-slate-800/80 p-5 rounded-2xl shadow-xl">
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Sedang Dipinjam</p>
            <p class="text-3xl font-black text-indigo-400 heading-font">{{ $stats['active_loans'] }}</p>
        </div>

        <div class="col-span-2 lg:col-span-1 bg-slate-900/40 border border-slate-800/80 p-5 rounded-2xl shadow-xl">
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Dikembalikan</p>
            <p class="text-3xl font-black text-emerald-400 heading-font">{{ $stats['returned_loans'] }}</p>
        </div>

    </div>

    <!-- BORROW REQUESTS TABLE CONTAINER -->
    <div class="bg-slate-900/40 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden">
        
        <div class="px-6 py-5 border-b border-slate-800 flex justify-between items-center">
            <h3 class="font-bold text-lg text-white heading-font">Daftar Transaksi Peminjaman</h3>
            <span class="text-xs bg-slate-800 border border-slate-700/80 text-slate-300 px-3 py-1 rounded-full font-medium">
                Total: {{ $borrowings->count() }} Entri
            </span>
        </div>

        @if($borrowings->isEmpty())
            <div class="p-16 text-center text-slate-500 text-sm">
                Belum ada transaksi peminjaman buku tercatat di dalam sistem database.
            </div>
        @else
            <!-- Responsive Table View -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-950/40 border-b border-slate-800 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Anggota</th>
                            <th class="px-6 py-4">Buku Pilihan</th>
                            <th class="px-6 py-4">Jadwal Pinjam</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-sm">
                        @foreach($borrowings as $b)
                            <tr class="hover:bg-slate-900/20 transition-all duration-150">
                                
                                <!-- User info -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-white">{{ $b->user->name ?? 'User' }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $b->user->email ?? '-' }}</div>
                                </td>

                                <!-- Book details -->
                                <td class="px-6 py-4 max-w-xs">
                                    <div class="font-semibold text-slate-200 line-clamp-1">{{ $b->book->title ?? '-' }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">Oleh: {{ $b->book->author ?? '-' }}</div>
                                </td>

                                <!-- Borrow & Due dates -->
                                <td class="px-6 py-4 text-xs space-y-1">
                                    <div>📅 Pinjam: <strong class="text-slate-300 font-medium">{{ $b->borrow_date ? date('d M Y', strtotime($b->borrow_date)) : '-' }}</strong></div>
                                    <div>📅 Kembali: <strong class="text-slate-300 font-medium">{{ $b->due_date ? date('d M Y', strtotime($b->due_date)) : '-' }}</strong></div>
                                </td>

                                <!-- Status indicator dynamic badges -->
                                <td class="px-6 py-4">
                                    @if($b->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/15 uppercase tracking-wide">
                                            ⏳ Menunggu
                                        </span>
                                    @elseif($b->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/15 uppercase tracking-wide">
                                            📖 Dipinjam
                                        </span>
                                    @elseif($b->status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-800 text-slate-400 border border-slate-700/80 uppercase tracking-wide">
                                            ❌ Ditolak
                                        </span>
                                    @elseif($b->status === 'returned')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/15 uppercase tracking-wide">
                                            ✔ Dikembalikan
                                        </span>
                                    @endif
                                </td>

                                <!-- Interactive approval action keys -->
                                <td class="px-6 py-4 text-center">
                                    @if($b->status === 'pending')
                                        <div class="flex items-center justify-center gap-2">
                                            
                                            <!-- Approve Button Form -->
                                            <form action="{{ route('admin.borrowings.approve', $b->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?');">
                                                @csrf
                                                <button type="submit" class="px-3.5 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-600/5 transition active:scale-95">
                                                    Setujui
                                                </button>
                                            </form>
                                            
                                            <!-- Reject Button Form -->
                                            <form action="{{ route('admin.borrowings.reject', $b->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak peminjaman ini?');">
                                                @csrf
                                                <button type="submit" class="px-3.5 py-2 rounded-lg bg-red-950/40 text-red-400 border border-red-900/60 hover:bg-red-600 hover:text-white hover:border-red-500 transition-all active:scale-95">
                                                    Tolak
                                                </button>
                                            </form>

                                        </div>
                                    @else
                                        <span class="text-xs text-slate-500 font-medium select-none italic">Selesai di-proses</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</div>
@endsection
