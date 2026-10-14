@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row mb-3 align-items-center">
            <div class="col-md-6">
                <h3 class="fw-bold">Data Peserta Sertifikasi</h3>
            </div>
            @if (Auth::user()->role === 'admin')    
            <div class="col-md-6 text-end">
                <form action="{{ route('peserta.index') }}" method="GET" class="d-inline-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2"
                        placeholder="Cari Nama / NIS / NIK..." value="{{ $search ?? '' }}">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Cari</button>
                </form>
            </div>
            @endif
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
                                <th>Status Ujian</th>
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
                                    <td>
                                        @if ($p->status == 'Kompeten')
                                            <span class="badge bg-success">Kompeten</span>
                                        @elseif($p->status == 'Belum Kompeten')
                                            <span class="badge bg-danger">Belum Kompeten</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Proses Ujian</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('peserta.show', $p->id) }}"
                                            class="btn btn-sm btn-info text-white fw-semibold me-1" title="Detail">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>

                                        <a href="{{ route('peserta.edit', $p->id) }}"
                                            class="btn btn-sm btn-warning text-dark fw-semibold me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit/Lengkapi
                                        </a>

                                        @if (Auth::user()->role === 'admin')
                                            <div class="dropdown d-inline me-1">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    Status
                                                </button>
                                                <ul class="dropdown-menu shadow-sm">
                                                    <li>
                                                        <form action="{{ route('peserta.updateStatus', $p->id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="Proses">
                                                            <button type="submit" class="dropdown-item small">
                                                                Proses</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('peserta.updateStatus', $p->id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="Kompeten">
                                                            <button type="submit"
                                                                class="dropdown-item small text-success fw-semibold">
                                                                Kompeten</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('peserta.updateStatus', $p->id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="Belum Kompeten">
                                                            <button type="submit"
                                                                class="dropdown-item small text-danger fw-semibold">
                                                                Belum Kompeten</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>

                                            <form action="{{ route('peserta.destroy', $p->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data peserta beserta akun loginnya?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    title="Hapus">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">Belum ada data peserta.</td>
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
