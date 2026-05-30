<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajah Buku</title>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" />
    <style>
        body {
            margin: 0;
            font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #0f172a;
            color: #e2e8f0;
        }
        .page-wrap {
            min-height: 100vh;
            padding: 2rem;
            background: linear-gradient(135deg, #0f172a 0%, #111827 100%);
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .title {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
        }
        .search-form {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: center;
        }
        .search-form input {
            padding: 0.85rem 1rem;
            border: 1px solid #334155;
            background: #0f172a;
            color: #e2e8f0;
            border-radius: 0.75rem;
            min-width: 240px;
        }
        .search-form button {
            padding: 0.85rem 1.3rem;
            border: none;
            border-radius: 0.75rem;
            background: #2563eb;
            color: white;
            cursor: pointer;
        }
        .books-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }
        .book-card {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 1.25rem;
            padding: 1.25rem;
            transition: transform 0.2s ease;
        }
        .book-card:hover {
            transform: translateY(-4px);
            border-color: rgba(96, 165, 250, 0.35);
        }
        .book-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #f8fafc;
        }
        .book-meta {
            font-size: 0.9rem;
            color: #94a3b8;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        .book-description {
            font-size: 0.9rem;
            color: #cbd5e1;
            min-height: 5rem;
        }
        .empty-state {
            padding: 3rem;
            text-align: center;
            background: rgba(15, 23, 42, 0.65);
            border: 1px dashed rgba(148, 163, 184, 0.35);
            border-radius: 1rem;
            color: #cbd5e1;
        }
        .pagination {
            margin-top: 1.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
            color: #e2e8f0;
        }
        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.12);
            color: #e2e8f0;
            text-decoration: none;
        }
        .pagination .active {
            background: #2563eb;
            border-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="page-wrap">
        <div class="header">
            <div>
                <h1 class="title">Jelajah Buku</h1>
                @if (!empty($search))
                    <p>Hasil pencarian untuk: <strong>{{ $search }}</strong></p>
                @endif
            </div>
            <form class="search-form" action="{{ route('books.index') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, penerbit, ISBN" autocomplete="off">
                <button type="submit">Cari</button>
            </form>
        </div>

        @if ($books->isEmpty())
            <div class="empty-state">
                <p>Tidak ada buku yang ditemukan.</p>
            </div>
        @else
            <div class="books-grid">
                @foreach ($books as $book)
                    <div class="book-card">
                        <h2 class="book-title">{{ $book->title }}</h2>
                        <p class="book-meta">{{ $book->author }} · {{ $book->publisher ?? 'Penerbit tidak diketahui' }}</p>
                        <p class="book-meta">Kategori: {{ optional($book->category)->name ?? 'Umum' }}</p>
                        <p class="book-description">{{ Str::limit($book->description ?? 'Tidak ada deskripsi.', 160) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</body>
</html>
