@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Skema Sertifikasi Baru</h5>
            </div>
            <div class="card-body">

                <!-- Untuk Pesan Validasi jika Inputan Kosong / Salah -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('skema.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Kode Skema</label>
                        <input type="text" name="kd_skema" class="form-control" value="{{ old('kd_skema') }}" placeholder="Contoh: SKM-001" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Skema</label>
                        <input type="text" name="nm_skema" class="form-control" value="{{ old('nm_skema') }}" placeholder="Contoh: Junior Web Developer" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('skema.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection