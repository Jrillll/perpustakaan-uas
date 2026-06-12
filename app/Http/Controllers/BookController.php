<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $genre = $request->query('genre');

        $genres = Category::orderBy('name')->pluck('name');

        $query = Book::with(['category', 'reviews']);

        if ($search) {
            $query->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($genre) {
            $query->whereHas('category', function ($sub) use ($genre) {
                $sub->where('name', $genre);
            });
        }

        $books = $query->orderBy('title')->get();

        $recommendedBooks = Book::with(['category', 'reviews'])
            ->where('stock', '>', 0)
            ->orderByDesc('stock')
            ->take(3)
            ->get();

        return view('user.books.index', compact(
            'books',
            'recommendedBooks',
            'genres',
            'search',
            'genre'
        ));
    }

        public function show(Book $book)
{
    $book->load(['category', 'reviews.user']);

    $total_buku = $book->stock;

    $dipinjam = Borrowing::where('book_id', $book->id)
        ->where('status', 'approved')
        ->count();

    $reviews = $book->reviews()->with('user')->latest()->get();

    return view('user.books.show', compact(
        'book',
        'reviews',
        'total_buku',
        'dipinjam'
    ));
}

    public function review(Request $request, Book $book)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'rating' => $request->rating,
            'comment' => $request->komentar,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}