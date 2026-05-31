<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function landing()
    {
        return view('welcome');
    }

    public function about()
    {
        return view('about');
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $genre = $request->query('genre');
        $query = Book::with('reviews');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        if ($genre) {
            $query->where('genre', $genre);
        }

        $books = $query->get();

        // Dynamically compute rating for each book
        foreach ($books as $book) {
            $book->dynamic_rating = $book->reviews->avg('rating') ?? 4;
        }

        // Distinct genres for filters
        $genres = Book::select('genre')
            ->whereNotNull('genre')
            ->where('genre', '!=', '')
            ->distinct()
            ->pluck('genre');

        // Recommended books: top 3 based on dynamic rating
        $allBooksForRecommendation = Book::with('reviews')->get();
        foreach ($allBooksForRecommendation as $b) {
            $b->dynamic_rating = $b->reviews->avg('rating') ?? 4;
        }
        $recommendedBooks = $allBooksForRecommendation->sortByDesc('dynamic_rating')->take(3);

        return view('user.books.index', compact('books', 'search', 'genres', 'genre', 'recommendedBooks'));
    }

    public function show(Book $book)
    {
        // Load reviews and users
        $reviews = Review::with('user')
            ->where('book_id', $book->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $total_buku = Book::sum('stock');

        // Sedang dipinjam: status is 'approved' (which corresponds to 'dipinjam')
        $dipinjam = Borrowing::where('status', 'approved')->count();

        // Calculate average rating
        $book->dynamic_rating = $reviews->avg('rating') ?? 4;

        return view('user.books.show', compact('book', 'reviews', 'total_buku', 'dipinjam'));
    }

    public function storeReview(Request $request, Book $book)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        Review::create([
            'book_id' => $book->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->komentar,
        ]);

        return redirect()->route('books.show', $book->id)
            ->with('success', 'Ulasan Anda berhasil dikirim!');
    }
}
