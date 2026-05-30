@extends('admin.layouts.app')

@section('content')
<div class="flex-1 p-0">

    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Laporan & Export</h2>
        <p class="text-gray-500 mt-1">Unduh laporan dalam format PDF atau CSV/Excel.</p>
    </div>

    {{-- Statistik Ringkasan --}}
    <div class="grid md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $summary['total_borrowings'] }}</h3>
                    <p class="text-gray-500 text-xs">Total Peminjaman</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $summary['approved_borrowings'] }}</h3>
                    <p class="text-gray-500 text-xs">Disetujui</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $summary['returned_borrowings'] }}</h3>
                    <p class="text-gray-500 text-xs">Dikembalikan</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition {{ $summary['unpaid_fines'] > 0 ? 'border-l-4 border-red-500' : '' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $summary['unpaid_fines'] }}</h3>
                    <p class="text-gray-500 text-xs">Denda Belum Bayar</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Unduh Laporan --}}
    <div class="bg-white rounded-xl shadow mb-6">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">📥 Unduh Laporan</h3>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.reports.pdf') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </a>
                <a href="{{ route('admin.reports.excel') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download Excel (CSV)
                </a>
            </div>
        </div>
    </div>

    {{-- Tabel Ringkasan Peminjaman --}}
    <div class="bg-white rounded-xl shadow">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">📊 Ringkasan Peminjaman</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($borrowings as $borrowing)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $borrowing->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $borrowing->user?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $borrowing->book?->title ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-orange-100 text-orange-700',
                                        'approved' => 'bg-blue-100 text-blue-700',
                                        'returned' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                    ];
                                    $color = $statusColors[$borrowing->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-2 py-1 text-xs font-bold {{ $color }} rounded-full">{{ strtoupper($borrowing->status) }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $borrowing->borrow_date ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $borrowing->due_date ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada data laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
