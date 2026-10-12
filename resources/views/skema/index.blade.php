@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Skema Sertifikasi</h3>
    <a href="{{ route('skema.create') }}" class="btn btn-primary">+ Tambah Skema</a>
</div>

{{-- Tambahkan Alert Flash Message di sini --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="50">No</th>
                    <th>Kode Skema</th>
                    <th>Nama Skema</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($skemas as $index => $skema)
                <tr>
                    <td>{{ $skemas->firstItem() + $index }}</td>
                    <td>{{ $skema->kd_skema }}</td>
                    <td>{{ $skema->nm_skema }}</td>
                    <td>
                        <a href="{{ route('skema.edit', $skema->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        
                        <form action="{{ route('skema.destroy', $skema->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada data skema.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Navigasi Halaman (Pagination) -->
        {{ $skemas->links() }}
    </div>
</div>
@endsection