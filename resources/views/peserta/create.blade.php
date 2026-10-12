@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Data Peserta Baru</h5>
            </div>
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('peserta.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Skema Sertifikasi</label>
                        <select name="skema_id" class="form-select" required>
                            <option value="">-- Pilih Skema --</option>
                            @foreach($skemas as $skema)
                                <option value="{{ $skema->id }}" {{ old('skema_id') == $skema->id ? 'selected' : '' }}>
                                    {{ $skema->kd_skema }} - {{ $skema->nm_skema }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Peserta</label>
                        <input type="text" name="no_peserta" class="form-control" value="{{ old('no_peserta') }}" placeholder="Contoh: PST-2026-001" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap Peserta</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Contoh: budi@gmail.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('peserta.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan Peserta</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection