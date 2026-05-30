@extends('admin.layouts.app')

@section('content')
<div class="flex-1 p-0">

    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Manajemen Denda</h2>
        <p class="text-gray-500 mt-1">Pantau denda keterlambatan dan tandai telah dibayar.</p>
    </div>

    {{-- Ringkasan Denda --}}
    <div class="grid md:grid-cols-3 gap-4 mb-6">
        @php
            $totalDenda = $fines->sum('amount');
            $dendaLunas = $fines->where('status', 'paid')->sum('amount');
            $dendaBelum = $fines->where('status', 'unpaid')->sum('amount');
        @endphp
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gray-100 text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
                    <p class="text-gray-500 text-xs">Total Denda</p>
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
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($dendaLunas, 0, ',', '.') }}</h3>
                    <p class="text-gray-500 text-xs">Sudah Dibayar</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition {{ $dendaBelum > 0 ? 'border-l-4 border-red-500' : '' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($dendaBelum, 0, ',', '.') }}</h3>
                    <p class="text-gray-500 text-xs">Belum Dibayar</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Denda --}}
    <div class="bg-white rounded-xl shadow">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">💰 Daftar Denda</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Hari Terlambat</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nominal</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($fines as $fine)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $fine->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $fine->borrowing?->user?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $fine->borrowing?->book?->title ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-bold bg-orange-100 text-orange-700 rounded-full">{{ $fine->late_days }} hari</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($fine->status === 'paid')
                                    <span class="px-2 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">LUNAS</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">BELUM BAYAR</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($fine->status === 'unpaid')
                                    <form action="{{ route('admin.fines.mark-paid', $fine) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="px-3 py-1.5 text-sm bg-green-50 text-green-600 font-semibold rounded-lg hover:bg-green-100 transition">
                                            ✓ Tandai Lunas
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-300 text-sm">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada denda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
