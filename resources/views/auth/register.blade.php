<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" />
    <style>body{font-family:'Instrument Sans',sans-serif;background:#f8fafc;color:#111827;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;padding:1rem;}input,button{font:inherit;} .card{width:100%;max-width:420px;padding:2rem;background:#ffffff;box-shadow:0 10px 30px rgba(15,23,42,.08);border-radius:.75rem;} .field{margin-bottom:1rem;} .field label{display:block;margin-bottom:.35rem;font-weight:600;} .field input, .field textarea{width:100%;padding:.85rem 1rem;border:1px solid #d1d5db;border-radius:.55rem;background:#f8fafc;} .error{color:#b91c1c;font-size:.95rem;margin-top:.35rem;} .actions{display:flex;align-items:center;justify-content:space-between;margin-top:1.25rem;} .actions button{background:#ef4444;color:white;border:none;padding:.9rem 1.2rem;border-radius:.65rem;cursor:pointer;} .actions a{color:#1d4ed8;text-decoration:none;}</style>
</head>
<body>
    <div class="card">
        <h1 style="font-size:1.75rem;margin-bottom:1rem;">Register</h1>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="field">
                <label for="name">Nama</label>
                <input id="name" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')<p class="error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')<p class="error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password')<p class="error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <div class="field">
                <label for="phone">Telepon (opsional)</label>
                <input id="phone" name="phone" value="{{ old('phone') }}">
            </div>

            <div class="field">
                <label for="address">Alamat (opsional)</label>
                <textarea id="address" name="address" rows="3">{{ old('address') }}</textarea>
            </div>

            <div class="actions">
                <button type="submit">Daftar</button>
                <a href="{{ route('login') }}">Sudah punya akun?</a>
            </div>
        </form>
    </div>
</body>
</html>
