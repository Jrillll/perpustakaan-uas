<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" />
    <style>body{font-family:'Instrument Sans',sans-serif;background:#f8fafc;color:#111827;min-height:100vh;margin:0;padding:2rem;} .card{max-width:720px;margin:auto;background:#fff;padding:2rem;border-radius:.75rem;box-shadow:0 18px 50px rgba(15,23,42,.08);} .actions{margin-top:1.5rem;} .actions form{display:inline;} .btn{display:inline-flex;align-items:center;justify-content:center;padding:.85rem 1.2rem;border-radius:.65rem;border:none;background:#ef4444;color:#fff;text-decoration:none;cursor:pointer;}</style>
</head>
<body>
    <div class="card">
        <h1 style="font-size:2rem;margin-bottom:.75rem;">Dashboard</h1>
        <p style="margin-bottom:1rem;">Selamat datang, <strong>{{ auth()->user()->name }}</strong>! Kamu sudah login.</p>
        <p>Di sini kamu bisa lanjut ke halaman buku, peminjaman, atau fitur lain yang ada di aplikasi perpustakaan.</p>

        <div class="actions">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn" type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
