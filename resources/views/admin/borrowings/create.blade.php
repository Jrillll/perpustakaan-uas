@extends('admin.layouts.app')

@section('content')
<div class="flex-1 p-0">

    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Buat Peminjaman</h2>
        <p class="text-gray-500 mt-1">Buat data peminjaman on-site (langsung di tempat)</p>
    </div>

    <div class="bg-white rounded-xl shadow p-8 max-w-2xl">
        <form action="{{ route('admin.borrowings.store') }}" method="POST" class="space-y-6">
            @csrf
            
            {{-- User Selection --}}
            <div>
                <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilih User <span class="text-red-500">*</span>
                </label>
                <select id="user_id" name="user_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Book Selection --}}
            <div>
                <label for="book_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilih Buku <span class="text-red-500">*</span>
                </label>
                <select id="book_id" name="book_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                    <option value="">-- Pilih Buku --</option>
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }} {{ $book->stock <= 0 ? 'disabled' : '' }}>
                            {{ $book->title }} (Stok: {{ $book->stock }})
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Pinjam --}}
            <div>
                <label for="borrow_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal Pinjam <span class="text-red-500">*</span>
                </label>
                <input type="date" id="borrow_date" name="borrow_date" required value="{{ old('borrow_date', date('Y-m-d')) }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                @error('borrow_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Kembali --}}
            <div>
                <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal Kembali (Rencana) <span class="text-red-500">*</span>
                </label>
                <input type="date" id="due_date" name="due_date" required value="{{ old('due_date', \Carbon\Carbon::now()->addDays(7)->format('Y-m-d')) }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                @error('due_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold transition shadow flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Peminjaman
                </button>
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-lg font-semibold transition flex items-center gap-2">
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- Info Box --}}
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-xl max-w-2xl">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">ℹ️ Informasi</h3>
        <ul class="text-blue-800 space-y-2 text-sm">
            <li>✓ Gunakan fitur ini ketika user meminjam buku langsung di tempat</li>
            <li>✓ Data peminjaman akan langsung disetujui (dipinjam) dan tercatat di sistem</li>
            <li>✓ Stok buku akan otomatis berkurang</li>
            <li>✓ Pastikan pilihan user dan buku sudah benar sebelum submit</li>
        </ul>
    </div>

</div>
@endsection
