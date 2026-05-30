<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        $books = Book::with('category')->latest()->get();

        return view('admin.books.index', compact('categories', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'isbn' => ['nullable', 'string', 'max:255', 'unique:books,isbn'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('books', 'public');
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'isbn' => ['nullable', 'string', 'max:255', 'unique:books,isbn,' . $book->id],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            $validated['cover'] = $request->file('cover')->store('books', 'public');
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
