@extends('admin.layouts.app')

@section('content')
<div class="flex-1 p-0">

    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Verifikasi Peminjaman</h2>
        <p class="text-gray-500 mt-1">Kelola izin peminjaman, pengembalian, dan denda.</p>
    </div>

    {{-- Top Tabs --}}
    <div class="mb-6">
        <style>
            .tab-btn { border-bottom: 3px solid transparent; transition: all 0.2s ease; }
            .tab-btn.active-tab { background-color: rgba(219, 234, 254, 1); border-bottom-color: rgba(59, 130, 246, 1); color: rgba(30, 58, 138, 1); }
            .tab-btn:not(.active-tab) { color: rgba(75, 85, 99, 1); }
        </style>
        <nav class="bg-white rounded-xl shadow px-4 py-3 flex items-center gap-4" aria-label="Tabs">
            <button data-tab-target="pending" class="tab-btn active-tab flex items-center gap-3 px-4 py-2 rounded-md text-sm font-medium" aria-current="true">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-white border text-sm text-gray-700">🔔</span>
                <div class="text-left">
                    <div class="font-semibold">Permintaan Peminjaman</div>
                    <div class="text-xs text-gray-500">Total: {{ $pendingBorrowings->count() }}</div>
                </div>
                <div class="ml-auto">
                    <span class="px-2 py-0.5 text-xs font-bold bg-orange-100 text-orange-700 rounded-full">{{ $pendingBorrowings->count() }}</span>
                </div>
            </button>

            <button data-tab-target="active" class="tab-btn flex items-center gap-3 px-4 py-2 rounded-md text-sm font-medium">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-white border text-sm text-gray-700">📚</span>
                <div class="text-left">
                    <div class="font-semibold">Peminjaman Aktif</div>
                    <div class="text-xs text-gray-500">Total: {{ $approvedBorrowings->count() }}</div>
                </div>
                <div class="ml-auto">
                    <span class="px-2 py-0.5 text-xs font-bold bg-blue-100 text-blue-700 rounded-full">{{ $approvedBorrowings->count() }}</span>
                </div>
            </button>
        </nav>
    </div>

    {{-- Pending Tab Content --}}
    <div id="tab-pending" class="tab-content">
        <div class="bg-white rounded-xl shadow mb-6">
            <div class="border-b px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">⏳ Menunggu Persetujuan</h3>
                @if($pendingBorrowings->count() > 0)
                    <span class="px-3 py-1 text-xs font-bold bg-orange-100 text-orange-700 rounded-full">{{ $pendingBorrowings->count() }} pending</span>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Permintaan</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pendingBorrowings as $borrowing)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $borrowing->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $borrowing->user?->username ?? ($borrowing->user?->name ?? '-') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $borrowing->book?->title ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($borrowing->borrow_date ?? $borrowing->created_at)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.borrowings.approve', $borrowing) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1.5 text-sm bg-green-50 text-green-600 font-semibold rounded-lg hover:bg-green-100 transition">
                                                ✓ Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.borrowings.reject', $borrowing) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1.5 text-sm bg-red-50 text-red-600 font-semibold rounded-lg hover:bg-red-100 transition">
                                                ✕ Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada peminjaman pending.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Active Tab Content (approved + returned) --}}
    <div id="tab-active" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow mb-6">
            <div class="border-b px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">📖 Sedang Dipinjam</h3>
                @if($approvedBorrowings->count() > 0)
                    <span class="px-3 py-1 text-xs font-bold bg-blue-100 text-blue-700 rounded-full">{{ $approvedBorrowings->count() }} aktif</span>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Peminjam</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Kembali Rencana</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($approvedBorrowings as $borrowing)
                            @php
                                $dueDate = $borrowing->due_date ? \Carbon\Carbon::parse($borrowing->due_date) : null;
                                $isOverdue = $dueDate ? \Carbon\Carbon::now()->greaterThan($dueDate) : false;
                            @endphp
                            <tr class="border-b hover:bg-gray-50 transition {{ $isOverdue ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $borrowing->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $borrowing->user?->username ?? ($borrowing->user?->name ?? '-') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $borrowing->user?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $borrowing->book?->title ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $borrowing->borrow_date ? \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') : '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="{{ $isOverdue ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                        {{ $dueDate ? $dueDate->format('d/m/Y') : '-' }}
                                        {!! $isOverdue ? '<br><span class="text-red-500 text-xs">⚠️ TERLAMBAT</span>' : '' !!}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.borrowings.return', $borrowing) }}" method="POST" onsubmit="return confirmReturn('{{ addslashes($borrowing->user?->name ?? '-') }}','{{ addslashes($borrowing->book?->title ?? '-') }}')">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 text-sm bg-blue-50 text-blue-600 font-semibold rounded-lg hover:bg-blue-100 transition">
                                            📥 Kembalikan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada peminjaman aktif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Riwayat Pengembalian di bawah aktif --}}
        <div class="bg-white rounded-xl shadow">
            <div class="border-b px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">📋 Riwayat Pengembalian</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($returnedBorrowings as $borrowing)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $borrowing->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $borrowing->user?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $borrowing->book?->title ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">RETURNED</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $borrowing->return_date ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    (function(){
        function selectTab(target){
            document.querySelectorAll('.tab-content').forEach(function(el){ el.classList.add('hidden'); });
            document.querySelectorAll('.tab-btn').forEach(function(b){ b.classList.remove('active-tab'); });
            var show = document.getElementById('tab-' + target);
            if(show) show.classList.remove('hidden');
            var activeBtn = document.querySelector('[data-tab-target="'+target+'"]');
            if(activeBtn) activeBtn.classList.add('active-tab');
        }

        // wire buttons
        document.querySelectorAll('.tab-btn').forEach(function(btn){
            btn.addEventListener('click', function(e){
                var t = btn.getAttribute('data-tab-target');
                selectTab(t);
                // update hash for persistence/back button
                history.replaceState(null, '', '#'+t);
            });
        });

        // default tab from hash or pending
        var hash = window.location.hash.replace('#', '') || 'pending';
        selectTab(hash);
    })();
</script>
@endsection
