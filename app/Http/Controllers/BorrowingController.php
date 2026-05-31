<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function showBorrowForm(Book $book)
    {
        return view('user.books.borrow', compact('book'));
    }

    public function borrow(Request $request, Book $book)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'durasi' => 'required|integer|in:1,2,3',
        ]);

        $userId = Auth::id();

        // Check if user already has an active borrowing or pending request for this specific book
        $existing = Borrowing::where('book_id', $book->id)
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah mengajukan atau sedang meminjam buku ini!');
        }

        // Calculate due date (tanggal kembali)
        $borrowDate = Carbon::parse($request->tanggal_mulai);
        $dueDate = $borrowDate->copy()->addDays($request->durasi);

        Borrowing::create([
            'user_id' => $userId,
            'book_id' => $book->id,
            'borrow_date' => $borrowDate->toDateString(),
            'due_date' => $dueDate->toDateString(),
            'status' => 'pending', // Replaces 'menunggu'
        ]);

        return redirect()->route('borrowings.index')
            ->with('success', 'Pengajuan peminjaman berhasil! Menunggu persetujuan admin.');
    }

    public function index()
    {
        $userId = Auth::id();

        // Active, pending, and rejected borrowings
        $data = Borrowing::with('book')
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->get();

        $today = Carbon::today();

        // Calculate delays and fines dynamically for approved ones
        foreach ($data as $d) {
            if ($d->status === 'approved') {
                $dueDate = Carbon::parse($d->due_date);
                $d->telat = $today->gt($dueDate);

                if ($d->telat) {
                    $d->hari_telat = $today->diffInDays($dueDate);
                    $d->denda = $d->hari_telat * 10000;
                } else {
                    $d->hari_telat = 0;
                    $d->denda = 0;
                }
            } else {
                $d->telat = false;
                $d->hari_telat = 0;
                $d->denda = 0;
            }
        }

        return view('user.borrowings.index', compact('data'));
    }

    public function returnBook(Borrowing $borrowing)
    {
        // Security check
        if ($borrowing->user_id !== Auth::id()) {
            abort(403);
        }

        // Calculate and save return
        $borrowing->update([
            'status' => 'returned',
            'return_date' => Carbon::today()->toDateString(),
        ]);

        // Increment book stock
        $book = $borrowing->book;
        $book->increment('stock');

        return redirect()->route('borrowings.index')
            ->with('success', 'Buku berhasil dikembalikan!');
    }

    public function history()
    {
        $userId = Auth::id();

        // Historical borrowings (status is 'returned')
        $data = Borrowing::with('book')
            ->where('user_id', $userId)
            ->where('status', 'returned')
            ->orderBy('return_date', 'desc')
            ->get();

        return view('user.borrowings.history', compact('data'));
    }
}
