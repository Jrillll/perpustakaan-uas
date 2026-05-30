@extends('admin.layouts.app')

@section('content')
<div class="flex-1 p-0">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Data User</h2>
            <p class="text-gray-500 mt-1">Kelola akun user dan admin di sistem.</p>
        </div>
        <button onclick="document.getElementById('tambahUserForm').classList.toggle('hidden')"
                class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow">
            + Tambah User
        </button>
    </div>

    {{-- Form Tambah User (Hidden by default) --}}
    <div id="tambahUserForm" class="bg-white rounded-xl shadow mb-6 hidden">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">➕ Tambah User Baru</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="Nama lengkap">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="email@example.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required minlength="6"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="Min. 6 karakter">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" name="phone"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="08xxxxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" name="address"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="Alamat (opsional)">
                    </div>
                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow">
                            Simpan User
                        </button>
                        <button type="button" onclick="document.getElementById('tambahUserForm').classList.add('hidden')"
                                class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Data User --}}
    <div class="bg-white rounded-xl shadow">
        <div class="border-b px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">👥 Daftar User</h3>
            <span class="px-3 py-1 text-xs font-bold bg-purple-100 text-purple-700 rounded-full">{{ $users->count() }} user</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $user->id }}</td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                    @if($user->phone)
                                        <p class="text-xs text-gray-400">{{ $user->phone }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="px-2 py-1 text-xs font-bold bg-blue-100 text-blue-700 rounded-full">ADMIN</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-bold bg-gray-100 text-gray-600 rounded-full">USER</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button onclick="toggleEditRow({{ $user->id }})"
                                            class="px-3 py-1.5 text-sm bg-blue-50 text-blue-600 font-semibold rounded-lg hover:bg-blue-100 transition">
                                        Edit
                                    </button>
                                    @if($user->id != session('user_id'))
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1.5 text-sm bg-red-50 text-red-600 font-semibold rounded-lg hover:bg-red-100 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-3 py-1.5 text-xs text-gray-400 italic">Anda</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        {{-- Inline Edit Row --}}
                        <tr id="edit-row-{{ $user->id }}" class="hidden bg-blue-50/30">
                            <td colspan="6" class="px-6 py-4">
                                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid md:grid-cols-6 gap-3 items-end">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Nama</label>
                                            <input type="text" name="name" value="{{ $user->name }}" required
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                                            <input type="email" name="email" value="{{ $user->email }}" required
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Password Baru</label>
                                            <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Role</label>
                                            <select name="role" required
                                                    class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Telepon</label>
                                            <input type="text" name="phone" value="{{ $user->phone }}"
                                                   class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit"
                                                    class="px-4 py-1.5 text-sm bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                                Simpan
                                            </button>
                                            <button type="button" onclick="toggleEditRow({{ $user->id }})"
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
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function toggleEditRow(id) {
        const row = document.getElementById('edit-row-' + id);
        row.classList.toggle('hidden');
    }
</script>
@endsection
