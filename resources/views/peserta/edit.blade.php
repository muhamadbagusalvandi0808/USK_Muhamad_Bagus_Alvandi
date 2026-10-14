@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 fw-bold">Edit Profil Peserta</h5>
            </div>
            <div class="card-body p-4">

                {{-- Tampilkan Error Validasi jika ada --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('peserta.update', $peserta->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">NIK</label>
                            <input type="text" name="nik" class="form-control" value="{{ old('nik', $peserta->nik) }}" placeholder="Contoh: 3174xxxxxxxxxxxx" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nomor Induk Siswa (NIS)</label>
                            <input type="text" name="nis" class="form-control" value="{{ old('nis', $peserta->nis) }}" placeholder="Contoh: 0054" required>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $peserta->nama) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="jk" class="form-select" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('jk', $peserta->jk) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jk', $peserta->jk) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Pilih Skema Sertifikasi</label>
                            <select name="skema_id" class="form-select" required>
                                <option value="">-- Pilih Skema --</option>
                                @foreach($skemas as $skema)
                                    <option value="{{ $skema->id }}" {{ old('skema_id', $peserta->skema_id) == $skema->id ? 'selected' : '' }}>
                                        [{{ $skema->kd_skema }}] {{ $skema->nm_skema }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="telp" class="form-control" value="{{ old('telp', $peserta->telp) }}" placeholder="Contoh: 081234567890" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $peserta->email) }}" {{ Auth::user()->role !== 'admin' ? 'readonly' : '' }} required>
                        @if(Auth::user()->role !== 'admin')
                            <div class="form-text text-muted">Email terikat dengan akun login Anda dan tidak dapat diubah.</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat domisili lengkap..." required>{{ old('alamat', $peserta->alamat) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('peserta.index') }}" class="btn btn-secondary px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection