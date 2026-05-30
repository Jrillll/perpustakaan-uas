@extends('admin.layouts.app')

@section('content')
<div class="flex-1 p-0">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Data Buku</h2>
            <p class="text-gray-500 mt-1">Kelola katalog buku dan tambahkan buku baru.</p>
        </div>
        <button onclick="document.getElementById('tambahBukuForm').classList.toggle('hidden')"
                class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow">
            + Tambah Buku
        </button>
    </div>

    {{-- Form Tambah Buku (Hidden by default) --}}
    <div id="tambahBukuForm" class="bg-white rounded-xl shadow mb-6 hidden">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">➕ Tambah Buku</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input type="text" name="title" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="Judul buku">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
                        <input type="text" name="author" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="Nama penulis">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
                        <input type="text" name="publisher"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="Nama penerbit">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input type="number" name="publication_year"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="2024">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                        <input type="text" name="isbn"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="978-xxx-xxx">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                        <input type="number" name="stock" min="0" value="0" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampul</label>
                        <input type="file" name="cover" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                  placeholder="Deskripsi singkat buku (opsional)"></textarea>
                    </div>
                    <div class="md:col-span-4">
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow">
                            Simpan Buku
                        </button>
                        <button type="button" onclick="document.getElementById('tambahBukuForm').classList.add('hidden')"
                                class="ml-3 px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Daftar Buku --}}
    <div class="bg-white rounded-xl shadow">
        <div class="border-b px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">📚 Daftar Buku</h3>
            <span class="px-3 py-1 text-xs font-bold bg-purple-100 text-purple-700 rounded-full">{{ $books->count() }} buku</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sampul</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($books as $book)
                        <tr class="hover:bg-gray-50 transition" x-data="{ editing: false }">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $book->id }}</td>
                            <td class="px-6 py-4">
                                @if ($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}"
                                         class="w-12 h-16 object-cover rounded-lg shadow-sm">
                                @else
                                    <div class="w-12 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-gray-900">{{ $book->title }}</p>
                                @if($book->isbn)
                                    <p class="text-xs text-gray-400">ISBN: {{ $book->isbn }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $book->author }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-700 rounded-full">
                                    {{ $book->category?->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-sm font-bold {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $book->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    {{-- Edit Modal Toggle --}}
                                    <button onclick="toggleEditModal({{ $book->id }})"
                                            class="px-3 py-1.5 text-sm bg-blue-50 text-blue-600 font-semibold rounded-lg hover:bg-blue-100 transition">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 text-sm bg-red-50 text-red-600 font-semibold rounded-lg hover:bg-red-100 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {{-- Inline Edit Row --}}
                        <tr id="edit-row-{{ $book->id }}" class="hidden bg-blue-50/30">
                            <td colspan="7" class="px-6 py-4">
                                <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid md:grid-cols-4 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Kategori</label>
                                            <select name="category_id" required
                                                    class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Judul</label>
                                            <input type="text" name="title" value="{{ $book->title }}" required
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Penulis</label>
                                            <input type="text" name="author" value="{{ $book->author }}" required
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Penerbit</label>
                                            <input type="text" name="publisher" value="{{ $book->publisher }}"
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Tahun</label>
                                            <input type="number" name="publication_year" value="{{ $book->publication_year }}"
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">ISBN</label>
                                            <input type="text" name="isbn" value="{{ $book->isbn }}"
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Stok</label>
                                            <input type="number" name="stock" value="{{ $book->stock }}" min="0" required
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Ganti Sampul</label>
                                            <input type="file" name="cover" accept="image/*"
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg outline-none file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600">
                                        </div>
                                        <div class="md:col-span-3">
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi</label>
                                            <textarea name="description" rows="1"
                                                      class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">{{ $book->description }}</textarea>
                                        </div>
                                        <div class="flex items-end gap-2">
                                            <button type="submit"
                                                    class="px-4 py-1.5 text-sm bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                                Simpan
                                            </button>
                                            <button type="button" onclick="toggleEditModal({{ $book->id }})"
                                                    class="px-4 py-1.5 text-sm bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function toggleEditModal(id) {
        const row = document.getElementById('edit-row-' + id);
        row.classList.toggle('hidden');
    }
</script>
@endsection
