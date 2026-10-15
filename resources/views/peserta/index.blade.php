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
            <div class="card-body p-0" style="overflow: visible !important; min-height: 100px;">
                <div class="table-responsive" style="overflow: visible !important;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>NIS</th>
                                <th>Nama Lengkap</th>
                                <th>Skema</th>
                                <th>JK</th>
                                <th>Telepon</th>
                                <th>Status Verifikasi</th> <!-- TAMBAHAN KOLOM VERIFIKASI -->
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
                                    
                                    <!-- KOLOM BADGE STATUS VERIFIKASI -->
                                    <td>
                                        @if($p->status_verifikasi == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                        @endif
                                    </td>

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
                                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                                            <a href="{{ route('peserta.show', $p->id) }}"
                                                class="btn btn-sm btn-info text-white fw-semibold" title="Detail">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            @if(Auth::user()->role === 'user')
                                            <a href="{{ route('peserta.edit', $p->id) }}"
                                                class="btn btn-sm btn-warning text-dark fw-semibold" title="Edit">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            @endif
                                            @if (Auth::user()->role === 'admin')
                                                @if($p->status_verifikasi !== 'approved')
                                                    <form action="{{ route('peserta.verifikasi', $p->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success fw-semibold" 
                                                            onclick="return confirm('Setujui verifikasi data dan dokumen peserta ini?')" title="Verifikasi">
                                                            Verifikasi
                                                        </button>
                                                    </form>
                                                @endif

                                                <div class="dropdown d-inline">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" title="Ubah Status Ujian">
                                                        Status
                                                    </button>
                                                    <ul class="dropdown-menu shadow-sm">
                                                        <li>
                                                            <form action="{{ route('peserta.updateStatus', $p->id) }}" method="POST">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="status" value="Proses">
                                                                <button type="submit" class="dropdown-item small">Proses Ujian</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('peserta.updateStatus', $p->id) }}" method="POST">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="status" value="Kompeten">
                                                                <button type="submit" class="dropdown-item small text-success fw-semibold">Kompeten</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('peserta.updateStatus', $p->id) }}" method="POST">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="status" value="Belum Kompeten">
                                                                <button type="submit" class="dropdown-item small text-danger fw-semibold">Belum Kompeten</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
            <form action="{{ route('peserta.destroy', $p->id) }}" method="POST"
                class="d-inline"
                onsubmit="return confirm('Yakin ingin menghapus data peserta beserta akun loginnya?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                    Hapus
                </button>
            </form>
        @endif
    </div>
</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">Belum ada data peserta.</td>
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