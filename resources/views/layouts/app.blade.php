<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Sertifikasi - JWD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
        }
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,.05);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase tracking-wide" href="{{ route('dashboard') }}">
                 SERTIFIKASI <span class="badge bg-primary fs-6 ms-1">BNSP</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold text-white' : '' }}" href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('skema.*') ? 'active fw-bold text-white' : '' }}" href="{{ route('skema.index') }}">
                            Data Skema
                        </a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('peserta.*') ? 'active fw-bold text-white' : '' }}" href="{{ route('peserta.index') }}">
                            Data Peserta
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <span class="text-light small">
                         {{ Auth::user()->name ?? 'Administrator' }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm px-3" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
    <main class="container my-4 grow">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                <strong>Peringatan!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-top py-3 mt-auto">
        <div class="container text-center text-muted small">
            &copy; 2026 Uji Sertifikasi Kompetensi -- SMKN 64 Jakarta
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>