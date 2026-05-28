<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" />
    <style>body{font-family:'Instrument Sans',sans-serif;background:#f8fafc;color:#111827;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;padding:1rem;}input,button{font:inherit;} .card{width:100%;max-width:420px;padding:2rem;background:#ffffff;box-shadow:0 10px 30px rgba(15,23,42,.08);border-radius:.75rem;} .field{margin-bottom:1rem;} .field label{display:block;margin-bottom:.35rem;font-weight:600;} .field input{width:100%;padding:.85rem 1rem;border:1px solid #d1d5db;border-radius:.55rem;background:#f8fafc;} .error{color:#b91c1c;font-size:.95rem;margin-top:.35rem;} .actions{display:flex;align-items:center;justify-content:space-between;margin-top:1.25rem;} .actions button{background:#2563eb;color:white;border:none;padding:.9rem 1.2rem;border-radius:.65rem;cursor:pointer;} .actions a{color:#1d4ed8;text-decoration:none;}</style>
</head>
<body>
    <div class="card">
        <h1 style="font-size:1.75rem;margin-bottom:1rem;">Login</h1>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            @if ($errors->any())
                <div class="error" style="margin-bottom:1rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')<p class="error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="field" style="display:flex;align-items:center;gap:.5rem;">
                <input id="remember" type="checkbox" name="remember" style="width:1rem;height:1rem;">
                <label for="remember" style="margin:0;">Ingat saya</label>
            </div>

            <div class="actions">
                <button type="submit">Masuk</button>
                <a href="{{ route('register') }}">Daftar baru</a>
            </div>
        </form>
    </div>
</body>
</html>
