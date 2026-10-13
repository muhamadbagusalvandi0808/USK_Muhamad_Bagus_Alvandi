@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2>Dashboard Utama</h2>
        <p class="text-muted">Selamat datang di Aplikasi Pengelolaan Data Peserta Sertifikasi.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Skema Sertifikasi</h5>
                <p class="card-text display-6">Kelola Skema</p>
                <a href="{{ route('skema.index') }}" class="btn btn-light btn-sm text-primary">Lihat Data Skema &rarr;</a>
            </div>
        </div>
    </div>


    <div class="col-md-6 mb-3">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Peserta Sertifikasi</h5>
                <p class="card-text display-6">Kelola Peserta</p>
                <a href="{{ route('peserta.index') }}" class="btn btn-light btn-sm text-success">Lihat Data Peserta &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection