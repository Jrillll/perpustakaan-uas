@extends('admin.layouts.app')

@section('content')
<div class="flex-1 p-0">

    <h2 class="text-3xl font-bold mb-4">Dashboard Admin</h2>

    <p class="text-gray-700">
        Selamat datang, <b>{{ $username ?? session('username') ?? 'Admin' }}</b> 👋
    </p>

    <!-- Statistik Cards -->
    <div class="mt-6 grid md:grid-cols-5 gap-4">
        <!-- Total Buku -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747 0-5.002-4.5-10.747-10-10.747z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalBuku }}</h3>
                    <p class="text-gray-500 text-xs">Total Buku</p>
                </div>
            </div>
        </div>

        <!-- Total Stok -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalStok }}</h3>
                    <p class="text-gray-500 text-xs">Total Stok</p>
                </div>
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $peminjamanAktif }}</h3>
                    <p class="text-gray-500 text-xs">Sedang Dipinjam</p>
                </div>
            </div>
        </div>

        <!-- Terlambat -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition {{ $peminjamanTerlambat > 0 ? 'border-l-4 border-red-500' : '' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $peminjamanTerlambat }}</h3>
                    <p class="text-gray-500 text-xs">Terlambat</p>
                </div>
            </div>
        </div>

        <!-- Total User -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V8H2v12h5m5-13a4 4 0 110 8 4 4 0 010-8zm-7 4a7 7 0 0114 0v1H5v-1z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</h3>
                    <p class="text-gray-500 text-xs">Total User</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Statistik -->
    <div class="mt-6 grid md:grid-cols-3 gap-6">
        <!-- Card User -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">👥 Detail User</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Admin</span>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">{{ $totalAdmins }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">User Biasa</span>
                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full font-semibold">{{ $totalRegularUsers }}</span>
                </div>
            </div>
        </div>

        <!-- Card Peminjaman -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📊 Detail Peminjaman</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Peminjaman</span>
                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full font-semibold">{{ $totalPeminjaman }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Dikembalikan</span>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-semibold">{{ $peminjamanDikembalikan }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Ditolak</span>
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full font-semibold">{{ $peminjamanDitolak }}</span>
                </div>
            </div>
        </div>

        <!-- Card Quick Access -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">⚡ Quick Access</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.borrowings.index') }}" class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg text-blue-600 font-semibold transition">
                    ✔️ Verifikasi Peminjaman
                </a>
                <a href="{{ route('admin.borrowings.history') }}" class="block p-3 bg-green-50 hover:bg-green-100 rounded-lg text-green-600 font-semibold transition">
                    📋 Riwayat Peminjaman
                </a>
                <a href="{{ route('admin.users.index') }}" class="block p-3 bg-purple-50 hover:bg-purple-100 rounded-lg text-purple-600 font-semibold transition">
                    👥 Kelola User
                </a>
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div class="mt-6 bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">📈 Grafik Peminjaman (7 Hari Terakhir)</h3>
        <div class="relative h-72 w-full">
            <canvas id="borrowingsChart"></canvas>
        </div>
    </div>

</div>

<!-- Memuat library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('borrowingsChart').getContext('2d');
        const borrowingsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#2563eb', // text-blue-600
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        padding: 10,
                        titleFont: { size: 13 },
                        bodyFont: { size: 14, weight: 'bold' },
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0 // Hanya angka bulat
                        },
                        grid: {
                            color: '#f3f4f6',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
