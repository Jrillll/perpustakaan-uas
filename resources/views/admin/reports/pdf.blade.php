<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Admin</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        h1 { margin-bottom: 8px; }
    </style>
</head>
<body>
    <h1>Laporan Peminjaman</h1>
    <p>Dicetak pada {{ now()->format('d M Y H:i') }}</p>

    <h2>Data Peminjaman</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Status</th>
                <th>Tanggal Pinjam</th>
                <th>Jatuh Tempo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($borrowings as $borrowing)
                <tr>
                    <td>{{ $borrowing->id }}</td>
                    <td>{{ $borrowing->user?->name ?? '-' }}</td>
                    <td>{{ $borrowing->book?->title ?? '-' }}</td>
                    <td>{{ strtoupper($borrowing->status) }}</td>
                    <td>{{ $borrowing->borrow_date ?? '-' }}</td>
                    <td>{{ $borrowing->due_date ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Data Denda</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Hari Terlambat</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fines as $fine)
                <tr>
                    <td>{{ $fine->id }}</td>
                    <td>{{ $fine->borrowing?->user?->name ?? '-' }}</td>
                    <td>{{ $fine->borrowing?->book?->title ?? '-' }}</td>
                    <td>{{ $fine->late_days }}</td>
                    <td>Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
                    <td>{{ strtoupper($fine->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
