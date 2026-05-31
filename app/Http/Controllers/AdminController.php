<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        // Fetch all borrowing requests with books and users
        $borrowings = Borrowing::with(['book', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $stats = [
            'total_books' => Book::count(),
            'total_users' => User::where('role', 'user')->count(),
            'pending_requests' => Borrowing::where('status', 'pending')->count(),
            'active_loans' => Borrowing::where('status', 'approved')->count(),
            'returned_loans' => Borrowing::where('status', 'returned')->count(),
        ];

        return view('admin.dashboard', compact('borrowings', 'stats'));
    }

    public function approve(Borrowing $borrowing)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Peminjaman tidak dalam status pending.');
        }

        $book = $borrowing->book;

        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku habis! Tidak bisa menyetujui peminjaman.');
        }

        // Enforce approval status, update borrow date to today (or keep planned date if in the future)
        $borrowing->update([
            'status' => 'approved',
            'borrow_date' => Carbon::today()->toDateString(),
        ]);

        // Decrement book stock
        $book->decrement('stock');

        return back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    public function reject(Borrowing $borrowing)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Peminjaman tidak dalam status pending.');
        }

        $borrowing->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }
}
