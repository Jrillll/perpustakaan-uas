<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Digital</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&family=poppins:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('theme.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .navbar {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem 0;
            position: relative;
            z-index: 10;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-family: 'Poppins', sans-serif;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 0.5rem;
        }

        .nav-link:hover {
            color: #0ea5e9 !important;
        }

        .hero-section {
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="books" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse"><rect x="10" y="20" width="15" height="60" fill="%23064e3b" opacity="0.3"/><rect x="30" y="15" width="15" height="70" fill="%230891b2" opacity="0.25"/><rect x="50" y="25" width="15" height="50" fill="%230ea5e9" opacity="0.2"/><rect x="70" y="10" width="15" height="80" fill="%23706f6c" opacity="0.15"/></pattern></defs><rect width="1200" height="600" fill="none"/><rect width="1200" height="600" fill="url(%23books)"/></svg>') center/cover;
            opacity: 0.1;
        }

        .hero-content {
            position: relative;
            z-index: 5;
            text-align: center;
            color: white;
            max-width: 800px;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-family: 'Poppins', sans-serif;
            letter-spacing: -1px;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 1rem;
            font-family: 'Instrument Sans', sans-serif;
        }

        .hero-description {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }

        .btn-explore {
            display: inline-block;
            padding: 0.9rem 2.5rem;
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .btn-explore:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.4);
            color: white;
        }

        .carousel-nav {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 2rem;
            z-index: 10;
        }

        .carousel-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.05);
            color: white;
            cursor: pointer;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .carousel-btn:hover {
            border-color: #0ea5e9;
            background: rgba(14, 165, 233, 0.1);
            color: #0ea5e9;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .hero-description {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-lg">
            <a class="navbar-brand" href="#">📚 PerpusDigital</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About Us</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background"></div>
        <div class="hero-content">
            <h1 class="hero-title">Perpustakaan Digital</h1>
            <p class="hero-subtitle">Sistem Peminjaman Buku</p>
            <p class="hero-description">
                Platform digital untuk mengelola perpustakaan dengan mudah, cepat dan praktis.
                Jelajahi koleksi buku kami dengan lebih dari seribu judul yang tersedia.
            </p>
            <a href="{{ route('books.index') ?? '#' }}" class="btn-explore">Jelajah Buku</a>
        </div>

        <!-- Carousel Navigation -->
        <div class="carousel-nav">
            <button class="carousel-btn" onclick="previousSlide()">‹</button>
            <button class="carousel-btn" onclick="nextSlide()">›</button>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentSlide = 0;

        function nextSlide() {
            currentSlide++;
            updateCarousel();
        }

        function previousSlide() {
            currentSlide--;
            updateCarousel();
        }

        function updateCarousel() {
            console.log('Slide:', currentSlide);
        }
    </script>
</body>
</html>
