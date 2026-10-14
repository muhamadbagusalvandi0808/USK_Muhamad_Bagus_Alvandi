@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-3">
        <div class="col-md-6">
            <h3 class="fw-bold">Data Peserta Sertifikasi</h3>
        </div>
        <div class="col-md-6 text-end">
            {{-- Form Pencarian --}}
            <form action="{{ route('peserta.index') }}" method="GET" class="d-inline-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Nama / NIS / NIK..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-outline-primary btn-sm">Cari</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">No</th>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>Skema</th>
                            <th>JK</th>
                            <th>Telepon</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesertas as $index => $p)
                            <tr>
                                <td class="ps-3">{{ $pesertas->firstItem() + $index }}</td>
                                <td>
                                    <span class="fw-semibold">{{ $p->nis ?? '-' }}</span>
                                </td>
                                <td>
                                    {{ $p->nama }}<br>
                                    <small class="text-muted">{{ $p->email }}</small>
                                </td>
                                <td>{{ $p->skema->nm_skema ?? 'Belum Pilih Skema' }}</td>
                                <td>{{ $p->jk ?? '-' }}</td>
                                <td>{{ $p->telp ?? '-' }}</td>
                                <td class="text-center">
                                    {{-- Tombol Detail / Lihat --}}
                                    <a href="{{ route('peserta.show', $p->id) }}" class="btn btn-sm btn-info text-white fw-semibold me-1">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>

                                    {{-- Tombol Edit / Lengkapi --}}
                                    <a href="{{ route('peserta.edit', $p->id) }}" class="btn btn-sm btn-warning text-dark fw-semibold me-1">
                                        <i class="bi bi-pencil-square"></i> Edit/Lengkapi
                                    </a>

                                    {{-- Tombol Hapus (Hanya untuk Admin) --}}
                                    @if(Auth::user()->role === 'admin')
                                        <form action="{{ route('peserta.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data peserta.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            {{ $pesertas->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection