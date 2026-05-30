<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik mirip dashboard PHP lama
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalRegularUsers = $totalUsers - $totalAdmins;

        $totalBuku = Book::count();
        $totalStok = Book::sum('stock') ?? 0;

        $totalPeminjaman = Borrowing::count();
        $peminjamanAktif = Borrowing::where('status', 'approved')->count();
        $peminjamanDikembalikan = Borrowing::where('status', 'returned')->count();
        $peminjamanDitolak = Borrowing::where('status', 'rejected')->count();

        $peminjamanTerlambat = Borrowing::where('status', 'approved')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now()->toDateString())
            ->count();

        $recentBorrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->take(10)
            ->get();

        $overdueBorrowings = Borrowing::with(['user', 'book'])
            ->where('status', 'approved')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now()->toDateString())
            ->orderBy('due_date')
            ->get();

        $username = null;
        if (session('user_id')) {
            $u = User::find(session('user_id'));
            $username = $u?->name;
        }

        // Data for Graphic (Chart) - Borrowings per day for the last 7 days
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chartLabels[] = now()->subDays($i)->format('d M');
            $chartData[] = Borrowing::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'totalAdmins', 'totalRegularUsers',
            'totalBuku', 'totalStok',
            'totalPeminjaman', 'peminjamanAktif', 'peminjamanDikembalikan', 'peminjamanDitolak', 'peminjamanTerlambat',
            'recentBorrowings', 'overdueBorrowings', 'username',
            'chartLabels', 'chartData'
        ));
    }
}
