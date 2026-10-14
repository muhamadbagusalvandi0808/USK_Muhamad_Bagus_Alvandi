<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIPERSI JWD</title>
    <!-- Ini Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        }
        .form-control {
            padding: 0.65rem 0.85rem;
            font-size: 0.95rem;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }
    </style>
</head>
<body class="d-flex align-items-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-dark mb-1">FORM LOGIN</h4>
                        <p class="text-muted small">Sistem Sertifikasi Kompetensi</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger py-2 small mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="user123@gmail.com" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 py-2 fw-semibold shadow-sm mb-3">LOGIN</button>
                    </form>

                    <!-- Tautan Pindah ke Halaman Register -->
                    <div class="text-center text-muted small">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Daftar Sekarang</a>
                    </div>

                </div>
            </div>

            <!-- Catatan Kaki Kecil -->
            <div class="text-center mt-3 text-muted" style="font-size: 0.8rem;">
                &copy; 2026 Uji Sertifikasi Kompetensi. SMKN 64 Jakarta
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>