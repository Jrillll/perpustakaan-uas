<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Perpustakaan Digital</title>
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
            overflow-y: auto;
            color: #fff;
            padding: 2rem 0;
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

        .container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 500px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo-area {
            text-align: center;
            margin-bottom: 2rem;
            animation: slideDown 0.8s ease-out;
        }

        .logo-area h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .logo-area p {
            color: #cbd5e1;
            font-size: 0.95rem;
            font-weight: 500;
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

        .field {
            margin-bottom: 1.5rem;
        }

        .field label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #e2e8f0;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .field input,
        .field textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid rgba(148, 163, 184, 0.3);
            border-radius: 0.75rem;
            background: rgba(15, 23, 42, 0.5);
            color: #f1f5f9;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            font-family: inherit;
        }

        .field textarea {
            resize: vertical;
            min-height: 80px;
        }

        .field input:focus,
        .field textarea:focus {
            outline: none;
            border-color: rgba(96, 165, 250, 0.6);
            background: rgba(15, 23, 42, 0.7);
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
        }

        .field input::placeholder,
        .field textarea::placeholder {
            color: #64748b;
        }

        .error {
            color: #f87171;
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .error::before {
            content: "⚠";
            font-size: 1rem;
        }

        .btn-register {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            margin-bottom: 1rem;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(16, 185, 129, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: #64748b;
            font-size: 0.85rem;
            position: relative;
        }

        .divider::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(148, 163, 184, 0.3), transparent);
        }

        .divider span {
            background: rgba(30, 41, 59, 0.7);
            padding: 0 1rem;
            position: relative;
        }

        .footer-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .footer-link p {
            color: #cbd5e1;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .footer-link a {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
        }

        .footer-link a:hover {
            color: #93c5fd;
            border-bottom-color: #60a5fa;
        }

        .form-group-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

            .logo-area h1 {
                font-size: 2rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .form-group-2col {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="overlay"></div>

    <div class="container">
        <div class="logo-area">
            <h1>📚 PerpusDigital</h1>
            <p>Sistem Perpustakaan Digital</p>
        </div>

        <div class="card">
            <h2 class="card-title">Daftar</h2>
            <p class="card-subtitle">Buat akun untuk mengakses perpustakaan digital</p>

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                <div class="field">
                    <label for="name">Nama Lengkap</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Nama lengkap Anda"
                        required
                        autofocus
                    >
                    @error('name')<p class="error">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@example.com"
                        required
                    >
                    @error('email')<p class="error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group-2col">
                    <div class="field">
                        <label for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                        >
                        @error('password')<p class="error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            required
                        >
                    </div>
                </div>

                <div class="field">
                    <label for="phone">Telepon <span style="color: #94a3b8;">(opsional)</span></label>
                    <input
                        id="phone"
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="08XXXXXXXXXX"
                    >
                </div>

                <div class="field">
                    <label for="address">Alamat <span style="color: #94a3b8;">(opsional)</span></label>
                    <textarea
                        id="address"
                        name="address"
                        placeholder="Alamat lengkap Anda"
                    >{{ old('address') }}</textarea>
                </div>

                <button type="submit" class="btn-register">Daftar</button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <div class="footer-link">
                <p>Sudah memiliki akun?</p>
                <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>
</html>
