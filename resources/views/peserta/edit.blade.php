@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">Edit Data Peserta</h5>
                <a href="{{ route('peserta.index') }}" class="btn btn-sm btn-dark fw-semibold">Kembali</a>
            </div>
            <div class="card-body p-4">
                
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('peserta.update', $peserta->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $peserta->nama) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $peserta->email) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label fw-semibold">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $peserta->nik) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nis" class="form-label fw-semibold">NIS</label>
                            <input type="text" class="form-control" id="nis" name="nis" value="{{ old('nis', $peserta->nis) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="skema_id" class="form-label fw-semibold">Skema Sertifikasi</label>
                        <select class="form-select" id="skema_id" name="skema_id" required>
                            <option value="">-- Pilih Skema Sertifikasi --</option>
                            @foreach($skemas as $skema)
                                <option value="{{ $skema->id }}" {{ (old('skema_id', $peserta->skema_id) == $skema->id) ? 'selected' : '' }}>
                                    [{{ $skema->kd_skema }}] {{ $skema->nm_skema }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jk" class="form-label fw-semibold">Jenis Kelamin</label>
                            <select class="form-select" id="jk" name="jk">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ (old('jk', $peserta->jk) == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ (old('jk', $peserta->jk) == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telp" class="form-label fw-semibold">No. Telepon / WhatsApp</label>
                            <input type="text" class="form-control" id="telp" name="telp" value="{{ old('telp', $peserta->telp) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', $peserta->alamat) }}</textarea>
                    </div>

                    <hr class="my-4">
                    <h6 class="fw-bold text-secondary mb-3">Perbarui Dokumen Persyaratan (Opsional)</h6>
                    <p class="small text-muted">Biarkan kosong jika tidak ingin mengubah file KTP atau Ijazah yang sudah di-upload sebelumnya.</p>

                    <div class="row">
                        <!-- Upload KTP Baru -->
                        <div class="col-md-6 mb-3">
                            <label for="ktp" class="form-label fw-semibold">Ganti File KTP</label>
                            @if($peserta->ktp)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $peserta->ktp) }}" target="_blank" class="small text-decoration-none">
                                        <i class="bi bi-file-earmark-image"></i> Lihat KTP Saat Ini
                                    </a>
                                </div>
                            @endif
                            <input type="file" class="form-control" id="ktp" name="ktp" accept="image/*">
                        </div>

                        <!-- Upload Ijazah Baru -->
                        <div class="col-md-6 mb-3">
                            <label for="ijazah" class="form-label fw-semibold">Ganti File Ijazah</label>
                            @if($peserta->ijazah)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $peserta->ijazah) }}" target="_blank" class="small text-decoration-none">
                                        <i class="bi bi-file-earmark-text"></i> Lihat Ijazah Saat Ini
                                    </a>
                                </div>
                            @endif
                            <input type="file" class="form-control" id="ijazah" name="ijazah" accept="image/*,application/pdf">
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success fw-semibold px-4">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection