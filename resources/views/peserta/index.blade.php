@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Peserta Sertifikasi</h3>
    <a href="{{ route('peserta.create') }}" class="btn btn-primary">+ Tambah Peserta</a>
</div>

{{-- Form Pencarian --}}
<div class="row mb-3">
    <div class="col-md-6">
        <form action="{{ route('peserta.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari Berdasarkan Nama / No Peserta..." value="{{ $search }}">
            <button type="submit" class="btn btn-secondary">Cari</button>
            @if($search)
                <a href="{{ route('peserta.index') }}" class="btn btn-outline-danger">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="50">No</th>
                    <th>No Peserta</th>
                    <th>Nama Peserta</th>
                    <th>Email</th>
                    <th>Skema</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertas as $index => $peserta)
                <tr>
                    <td>{{ $pesertas->firstItem() + $index }}</td>
                    <td>{{ $peserta->no_peserta }}</td>
                    <td>{{ $peserta->nama }}</td>
                    <td>{{ $peserta->email }}</td>
                    <td><span class="badge bg-info text-dark">{{ $peserta->skema->nm_skema ?? '-' }}</span></td>
                    <td>
                        <a href="{{ route('peserta.show', $peserta->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                        <a href="{{ route('peserta.edit', $peserta->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        
                        <form action="{{ route('peserta.destroy', $peserta->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus peserta ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data peserta.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $pesertas->links() }}
    </div>
</div>
@endsection