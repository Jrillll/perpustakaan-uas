@extends('admin.layouts.app')

@section('content')
<div class="flex-1 p-0">

    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Riwayat Peminjaman</h2>
        <p class="text-gray-500 mt-1">Lihat semua data peminjaman yang telah tercatat</p>
    </div>

    {{-- Filter & Pencarian --}}
    <div class="bg-white rounded-xl shadow mb-6">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">🔍 Filter & Pencarian</h3>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('admin.borrowings.history') }}" class="space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cari (Username, Nama, atau Judul Buku)</label>
                        <input type="text" name="search" placeholder="Masukkan keyword..." value="{{ $search }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                            <option value="">-- Semua Status --</option>
                            <option value="approved" {{ $status_filter === 'approved' ? 'selected' : '' }}>Dipinjam ({{ $status_counts['approved'] }})</option>
                            <option value="returned" {{ $status_filter === 'returned' ? 'selected' : '' }}>Dikembalikan ({{ $status_counts['returned'] }})</option>
                            <option value="rejected" {{ $status_filter === 'rejected' ? 'selected' : '' }}>Ditolak ({{ $status_counts['rejected'] }})</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                    <a href="{{ route('admin.borrowings.history') }}"
                       class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Peminjaman</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $riwayat_list->count() }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-50 text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $status_counts['approved'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-orange-50 text-orange-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Sudah Dikembalikan</p>
                    <p class="text-3xl font-bold text-green-600">{{ $status_counts['returned'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-50 text-green-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Peminjaman --}}
    <div class="bg-white rounded-xl shadow">
        <div class="border-b px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">📊 Daftar Riwayat Peminjaman</h3>
            <span class="px-3 py-1 text-xs font-bold bg-blue-100 text-blue-700 rounded-full">Total: {{ $riwayat_list->count() }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Kembali Rencana</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($riwayat_list as $index => $riwayat)
                        @php
                            $is_overdue = false;
                            if ($riwayat->status === 'approved' && $riwayat->due_date) {
                                $is_overdue = now()->startOfDay()->greaterThan(\Carbon\Carbon::parse($riwayat->due_date)->startOfDay());
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition {{ $is_overdue ? 'bg-red-50/50' : '' }}">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $riwayat->user?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $riwayat->book?->title ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $riwayat->borrow_date ?? $riwayat->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-sm {{ $is_overdue ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                {{ $riwayat->due_date ?? '-' }}
                                @if($is_overdue)
                                    <br><span class="text-red-500 text-xs">⚠️ TERLAMBAT</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $status_class = 'bg-gray-100 text-gray-800';
                                    $status_label = '⏳ Pending';
                                    
                                    if ($riwayat->status === 'approved') {
                                        if ($is_overdue) {
                                            $status_class = 'bg-red-100 text-red-800';
                                            $status_label = '⏳ Dipinjam (TERLAMBAT)';
                                        } else {
                                            $status_class = 'bg-orange-100 text-orange-800';
                                            $status_label = '⏳ Dipinjam';
                                        }
                                    } elseif ($riwayat->status === 'returned') {
                                        $status_class = 'bg-green-100 text-green-800';
                                        $status_label = '✅ Dikembalikan';
                                    } elseif ($riwayat->status === 'rejected') {
                                        $status_class = 'bg-gray-100 text-gray-800';
                                        $status_label = '❌ Ditolak';
                                    }
                                @endphp
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $status_class }}">
                                    {{ $status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-600 mb-1">Tidak Ada Data Peminjaman</h4>
                                <p class="text-gray-500">Tidak ada peminjaman yang sesuai dengan filter pencarian Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
