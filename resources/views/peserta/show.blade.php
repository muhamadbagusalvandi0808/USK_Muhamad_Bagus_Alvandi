@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">Detail Data Peserta</h5>
                <a href="{{ route('peserta.index') }}" class="btn btn-sm btn-light fw-semibold">Kembali</a>
            </div>
            <div class="card-body p-4">
                <table class="table table-striped table-bordered align-middle">
                    <tr>
                        <th width="30%">NIS</th>
                        <td>{{ $peserta->nis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>{{ $peserta->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td class="fw-semibold">{{ $peserta->nama }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $peserta->jk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Skema Sertifikasi</th>
                        <td>
                            @if($peserta->skema)
                                <span class="badge bg-primary">[{{ $peserta->skema->kd_skema }}] {{ $peserta->skema->nm_skema }}</span>
                            @else
                                <span class="text-muted">Belum Pilih Skema</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $peserta->email }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon / WA</th>
                        <td>{{ $peserta->telp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Lengkap</th>
                        <td>{{ $peserta->alamat ?? '-' }}</td>
                    </tr>
                </table>

                <div class="mt-4 text-end">
                    <a href="{{ route('peserta.edit', $peserta->id) }}" class="btn btn-warning fw-semibold px-4">Edit Data Ini</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection