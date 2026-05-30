<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Perpustakaan Digital</title>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            overflow: hidden;
            color: #fff;
            flex-direction: column;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%25" style="stop-color:%231e3a8a;stop-opacity:0.3" /><stop offset="100%25" style="stop-color:%230c4a6e;stop-opacity:0.3" /></linearGradient></defs><rect width="1200" height="800" fill="url(%23grad1)"/><circle cx="150" cy="100" r="80" fill="%23475569" opacity="0.1"/><circle cx="1050" cy="700" r="120" fill="%232563eb" opacity="0.08"/><rect x="100" y="200" width="200" height="300" fill="%236366f1" opacity="0.05" rx="20"/><rect x="900" y="100" width="180" height="400" fill="%23818cf8" opacity="0.05" rx="20"/><path d="M200 400 Q300 300 400 400" stroke="%234f46e5" stroke-width="2" fill="none" opacity="0.1"/><path d="M800 200 Q900 100 1000 200" stroke="%234f46e5" stroke-width="2" fill="none" opacity="0.1"/></svg>') center/cover;
            z-index: 0;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.7) 0%, rgba(30, 41, 59, 0.8) 50%, rgba(15, 23, 42, 0.7) 100%);
            z-index: 1;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
            padding: 1rem 2rem;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .navbar-links {
            display: flex;
            gap: 1.5rem;
        }

        .navbar-links a {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .navbar-links a:hover {
            color: #60a5fa;
        }

        .container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 600px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 5rem;
        }

        .card {
            width: 100%;
            padding: 2.5rem;
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 1.5rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.8s ease-out;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #f1f5f9;
        }

        .card-subtitle {
            color: #cbd5e1;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .welcome-message {
            color: #cbd5e1;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .welcome-message strong {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 600;
        }

        .description {
            color: #cbd5e1;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .btn-explore {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
        }

        .btn-explore:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-explore:active {
            transform: translateY(0);
        }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(239, 68, 68, 0.4);
            color: white;
        }

        .btn-logout:active {
            transform: translateY(0);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 640px) {
            .card {
                padding: 2rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .navbar {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .navbar-links {
                gap: 1rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="overlay"></div>

    <nav class="navbar">
        <a class="navbar-brand" href="/">📚 PerpusDigital</a>
        <div class="navbar-links">
            <a href="/">Home</a>
            <a href="#about">About Us</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="card-title">Dashboard</h2>
            <p class="card-subtitle">Selamat datang di Perpustakaan Digital</p>
            <p class="welcome-message">Halo, <strong>{{ auth()->user()->name }}</strong>! 👋</p>
            <p class="description">
                Anda sudah berhasil login ke Perpustakaan Digital. Di sini Anda bisa menjelajahi koleksi buku, melakukan peminjaman, mengelola daftar peminjaman, atau mengakses fitur lain dalam aplikasi perpustakaan.
            </p>

            <div class="actions">
                <a href="{{ route('books.index') ?? '#' }}" class="btn btn-explore"> Jelajah Buku</a>
                <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                    @csrf
                    <button type="submit" class="btn btn-logout"> Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
