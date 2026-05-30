@extends('admin.layouts.app')

@section('content')
<div class="flex-1 p-0">

    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Kelola Kategori</h2>
        <p class="text-gray-500 mt-1">Tambah, edit, dan hapus kategori buku.</p>
    </div>

    {{-- Form Tambah Kategori --}}
    <div class="bg-white rounded-xl shadow mb-6">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">➕ Tambah Kategori</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-5 gap-4 items-end">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="Masukkan nama kategori">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <input type="text" name="description"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="Deskripsi kategori (opsional)">
                    </div>
                    <div>
                        <button type="submit"
                                class="w-full px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Daftar Kategori --}}
    <div class="bg-white rounded-xl shadow">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">📋 Daftar Kategori</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $category->id }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $category->name }}" required
                                           class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition w-36">
                                    <input type="text" name="description" value="{{ $category->description }}"
                                           class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition w-48 hidden md:block">
                                    <button type="submit"
                                            class="px-3 py-1.5 text-sm bg-blue-50 text-blue-600 font-semibold rounded-lg hover:bg-blue-100 transition">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $category->description ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 text-sm bg-red-50 text-red-600 font-semibold rounded-lg hover:bg-red-100 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
