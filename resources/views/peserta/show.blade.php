@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Data Peserta</h5>
                <a href="{{ route('peserta.index') }}" class="btn btn-sm btn-light">Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-striped border">
                    <tr>
                        <th width="30%">No Peserta</th>
                        <td>: {{ $peserta->no_peserta }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>: {{ $peserta->nama }}</td>
                    </tr>
                    <tr>
                        <th>Skema Sertifikasi</th>
                        <td>: <span class="badge bg-primary">{{ $peserta->skema->kd_skema }} - {{ $peserta->skema->nm_skema }}</span></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>: {{ $peserta->email }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: {{ $peserta->alamat }}</td>
                    </tr>
                </table>

                <div class="mt-3 text-end">
                    <a href="{{ route('peserta.edit', $peserta->id) }}" class="btn btn-warning">Edit Data Ini</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection