<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - SIPERSI JWD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f172a; /* Warna dark biru pekat sederhana */
            color: #f8fafc;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Top Header Sederhana */
        header {
            border-bottom: 1px solid #1e293b;
        }

        .brand-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #ffffff;
            text-decoration: none;
        }

        /* Hero Content Simple */
        .hero-title {
            font-weight: 700;
            font-size: 2.25rem;
            color: #ffffff;
            margin-bottom: 1rem;
        }

        .hero-desc {
            color: #94a3b8;
            font-size: 1.05rem;
            max-width: 600px;
            margin: 0 auto 2rem auto;
            line-height: 1.6;
        }

        /* Style Button Sederhana */
        .btn-primary-custom {
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            border-radius: 6px;
        }

        .btn-primary-custom:hover {
            background-color: #1d4ed8;
            color: #ffffff;
        }

        .btn-outline-custom {
            background-color: transparent;
            color: #cbd5e1;
            border: 1px solid #334155;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            border-radius: 6px;
        }

        .btn-outline-custom:hover {
            background-color: #1e293b;
            color: #ffffff;
            border-color: #475569;
        }

        /* Footer */
        footer {
            border-top: 1px solid #1e293b;
            color: #64748b;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

    <header class="py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="#" class="brand-title">SIPERSI JWD</a>
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-custom btn-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-custom btn-sm">Masuk</a>
                    @endauth
                </div>
            @endif
        </div>
    </header>

    <main class="container text-center my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="hero-title">Sistem Informasi Uji Sertifikasi<br>Junior Web Developer</h1>
                <p class="hero-desc">
                    Platform terpadu untuk pengelolaan data skema dan peserta uji kompetensi sertifikasi secara efisien dan terstruktur.
                </p>
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom">Masuk ke Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary-custom">Masuk / Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 fw-semibold">Registrasi</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </main>

    <footer class="py-3 text-center">
        <div class="container">
            &copy; 2026 Uji Sertifikasi Kompetensi — SMKN 64 Jakarta
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>