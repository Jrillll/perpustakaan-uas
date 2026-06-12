<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>
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

        .field input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid rgba(148, 163, 184, 0.3);
            border-radius: 0.75rem;
            background: rgba(15, 23, 42, 0.5);
            color: #f1f5f9;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .field input:focus {
            outline: none;
            border-color: rgba(96, 165, 250, 0.6);
            background: rgba(15, 23, 42, 0.7);
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
        }

        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper input {
            padding-right: 3.5rem;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 2.3rem;
            height: 2.3rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
            color: #cbd5e1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0;
            transition: all 0.2s ease;
            padding: 0;
            line-height: 1;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.02);
        }

        .password-toggle svg {
            width: 1.2rem;
            height: 1.2rem;
        }

        .password-toggle:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.18);
        }

        .field input::placeholder {
            color: #64748b;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 1.1rem;
            height: 1.1rem;
            cursor: pointer;
            accent-color: #60a5fa;
        }

        .checkbox-group label {
            margin: 0;
            font-weight: 500;
            color: #cbd5e1;
            font-size: 0.9rem;
            cursor: pointer;
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

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
            margin-bottom: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.4);
        }

        .btn-login:active {
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
            <h2 class="card-title">Masuk</h2>
            <p class="card-subtitle">Akses koleksi buku digital Anda</p>

            @if ($errors->any())
                <div class="error" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); padding: 0.75rem 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; color: #fca5a5; display: block;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@example.com"
                        required
                        autofocus
                    >
                    @error('email')<p class="error">{{ $message }}</p>@enderror
                </div>

                <div class="field password-wrapper">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Masukkan password Anda"
                        required
                    >
                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Tampilkan atau sembunyikan password">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg" id="passwordEyeIcon">
                            <path d="M1.5 12C3.3 7.2 7.3 4 12 4c4.7 0 8.7 3.2 10.5 8-1.8 4.8-5.8 8-10.5 8C7.3 20 3.3 16.8 1.5 12Z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                    @error('password')<p class="error">{{ $message }}</p>@enderror
                </div>

                <div class="checkbox-group">
                    <input id="remember" type="checkbox" name="remember" value="1">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <div class="footer-link">
                <p>Belum memiliki akun?</p>
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');
            const passwordIcon = document.getElementById('passwordEyeIcon');

            const eyeIcon = '<path d="M1.5 12C3.3 7.2 7.3 4 12 4c4.7 0 8.7 3.2 10.5 8-1.8 4.8-5.8 8-10.5 8C7.3 20 3.3 16.8 1.5 12Z" /><circle cx="12" cy="12" r="3" />';
            const eyeOffIcon = '<path d="M1.5 12C3.3 7.2 7.3 4 12 4c4.7 0 8.7 3.2 10.5 8-1.8 4.8-5.8 8-10.5 8C7.3 20 3.3 16.8 1.5 12Z" /><circle cx="12" cy="12" r="3" /><path d="M4.5 4.5L19.5 19.5" />';

            toggleButton.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                passwordIcon.innerHTML = isPassword ? eyeOffIcon : eyeIcon;
            });
        });
    </script>
</body>
</html>
