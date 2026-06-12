<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function index()
    {
        $pendingBorrowings = Borrowing::with(['user', 'book'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $approvedBorrowings = Borrowing::with(['user', 'book'])
            ->where('status', 'approved')
            ->latest()
            ->get();

        $returnedBorrowings = Borrowing::with(['user', 'book'])
            ->where('status', 'returned')
            ->latest()
            ->get();

        return view('admin.borrowings.index', compact('pendingBorrowings', 'approvedBorrowings', 'returnedBorrowings'));
    }

    public function history(Request $request)
    {
        $status_filter = $request->input('status');
        $search = $request->input('search');

        $query = Borrowing::with(['user', 'book']);

        if ($status_filter) {
            $query->where('status', $status_filter);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            })->orWhereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        $riwayat_list = $query->latest()->get();

        $status_counts = [
            'approved' => Borrowing::where('status', 'approved')->count(),
            'returned' => Borrowing::where('status', 'returned')->count(),
            'rejected' => Borrowing::where('status', 'rejected')->count(),
        ];

        return view('admin.borrowings.history', compact('riwayat_list', 'search', 'status_filter', 'status_counts'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        $books = Book::orderBy('title')->get();

        return view('admin.borrowings.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $book = Book::lockForUpdate()->findOrFail($request->book_id);

                if ($book->stock <= 0) {
                    throw new \RuntimeException('Stok buku tidak tersedia! Semua buku dalam judul ini sudah dipinjam.');
                }

                Borrowing::create([
                    'user_id' => $request->user_id,
                    'book_id' => $request->book_id,
                    'borrow_date' => $request->borrow_date,
                    'due_date' => $request->due_date,
                    'status' => 'approved',
                ]);

                $book->decrement('stock');
            });

            return redirect()->route('admin.borrowings.create')->with('success', 'Peminjaman on-site berhasil dibuat!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function approve(Borrowing $borrowing)
    {
        try {
            DB::transaction(function () use ($borrowing) {
                if ($borrowing->status !== 'pending') {
                    return;
                }

                $book = $borrowing->book()->lockForUpdate()->first();

                if ($book->stock <= 0) {
                    throw new \RuntimeException('Stok buku tidak tersedia.');
                }

                $borrowing->update([
                    'status' => 'approved',
                    'borrow_date' => now()->toDateString(),
                    'due_date' => now()->addDays(7)->toDateString(),
                ]);

                $book->decrement('stock');
            });

            return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman disetujui.');
        } catch (\Throwable $e) {
            return redirect()->route('admin.borrowings.index')->with('error', $e->getMessage());
        }
    }

    public function reject(Borrowing $borrowing)
    {
        $borrowing->update([
            'status' => 'rejected',
        ]);

        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman ditolak.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        try {
            DB::transaction(function () use ($borrowing) {
                if ($borrowing->status === 'returned') {
                    return;
                }

                $borrowing->update([
                    'status' => 'returned',
                    'return_date' => now()->toDateString(),
                ]);

                $book = $borrowing->book()->lockForUpdate()->first();
                $book->increment('stock');

                $dueDate = $borrowing->due_date ? \Carbon\Carbon::parse($borrowing->due_date) : null;
                if ($dueDate && now()->greaterThan($dueDate) && !$borrowing->fine()->exists()) {
                    $lateDays = max(1, now()->diffInDays($dueDate));
                    $amount = $lateDays * 1000;

                    Fine::create([
                        'borrowing_id' => $borrowing->id,
                        'late_days' => $lateDays,
                        'amount' => $amount,
                        'status' => 'unpaid',
                    ]);
                }
            });

            return redirect()->route('admin.borrowings.index')->with('success', 'Buku dikembalikan.');
        } catch (\Throwable $e) {
            return redirect()->route('admin.borrowings.index')->with('error', $e->getMessage());
        }
    }
}
