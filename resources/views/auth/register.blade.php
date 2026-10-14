<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - SIPERSI JWD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
        }
        .form-control {
            padding: 0.70rem 1rem;
            font-size: 0.95rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.12);
            border-color: #86b7fe;
        }
        .btn-dark {
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }
        .btn-dark:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="d-flex align-items-center py-4">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <div class="badge bg-dark bg-opacity-10 text-dark px-3 py-1 rounded-pill mb-3 fw-semibold" style="font-size: 0.75rem;">BNSP ID</div>
                        <h4 class="fw-bold text-dark mb-1">Pendaftaran Akun</h4>
                        <p class="text-muted small">Buat akun peserta uji kompetensi baru</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger py-2 small mb-3 border-0 rounded-8">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 py-2.5 fw-semibold shadow-sm mb-3">DAFTAR SEKARANG</button>
                    </form>

                    <div class="text-center text-muted small">
                        Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary">Login disini</a>
                    </div>

                </div>
            </div>

            <div class="text-center mt-4 text-muted" style="font-size: 0.8rem;">
                &copy; 2026 Uji Sertifikasi Kompetensi -- SMKN 64 Jakarta
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>