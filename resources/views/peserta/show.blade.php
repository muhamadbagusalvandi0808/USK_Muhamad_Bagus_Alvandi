@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold">Detail Data Peserta</h3>
                <a href="{{ route('peserta.index') }}" class="btn btn-secondary btn-sm">
                    &larr; Kembali ke Daftar Peserta
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0">Informasi Pribadi & Akademik</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Nama Lengkap</div>
                        <div class="col-md-8">: {{ $peserta->nama }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Email</div>
                        <div class="col-md-8">: {{ $peserta->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">NIK</div>
                        <div class="col-md-8">: {{ $peserta->nik ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">NIS</div>
                        <div class="col-md-8">: {{ $peserta->nis ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Skema Sertifikasi</div>
                        <div class="col-md-8">: {{ $peserta->skema->nm_skema ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Jenis Kelamin</div>
                        <div class="col-md-8">: {{ $peserta->jk ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">No. Telepon / WhatsApp</div>
                        <div class="col-md-8">: {{ $peserta->telp ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Alamat Lengkap</div>
                        <div class="col-md-8">: {{ $peserta->alamat ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Status Verifikasi Akun</div>
                        <div class="col-md-8">: 
                            @if($peserta->status_verifikasi == 'approved')
                                <span class="badge bg-success">Disetujui / Terverifikasi</span>
                            @else
                                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold text-secondary">Status Hasil Ujian</div>
                        <div class="col-md-8">: 
                            @if ($peserta->status == 'Kompeten')
                                <span class="badge bg-success">Kompeten</span>
                            @elseif($peserta->status == 'Belum Kompeten')
                                <span class="badge bg-danger">Belum Kompeten</span>
                            @else
                                <span class="badge bg-warning text-dark">Proses Ujian</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Dokumen Persyaratan (KTP & Ijazah) -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white py-3">
                    <h5 class="mb-0">Dokumen Lampiran (KTP & Ijazah)</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center">
                        <!-- Preview KTP -->
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-semibold text-secondary mb-2">Foto KTP</h6>
                            @if($peserta->ktp)
                                <div class="border rounded p-2 bg-light mb-2" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('storage/' . $peserta->ktp) }}" alt="KTP Peserta" class="img-fluid rounded" style="max-height: 250px;">
                                </div>
                                <a href="{{ asset('storage/' . $peserta->ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-search"></i> Lihat Ukuran Penuh
                                </a>
                            @else
                                <p class="text-muted italic">KTP belum diunggah.</p>
                            @endif
                        </div>

                        <!-- Preview Ijazah -->
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-semibold text-secondary mb-2">Scan / Foto Ijazah</h6>
                            @if($peserta->ijazah)
                                <div class="border rounded p-2 bg-light mb-2" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                    @php
                                        $extension = pathinfo($peserta->ijazah, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(strtolower($extension) === 'pdf')
                                        <div class="text-center py-5">
                                            <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>
                                            <p class="small text-muted mt-2">File berformat PDF</p>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $peserta->ijazah) }}" alt="Ijazah Peserta" class="img-fluid rounded" style="max-height: 250px;">
                                    @endif
                                </div>
                                <a href="{{ asset('storage/' . $peserta->ijazah) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-search"></i> Buka / Unduh Dokumen
                                </a>
                            @else
                                <p class="text-muted italic">Ijazah belum diunggah.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection