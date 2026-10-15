@extends('layouts.app')

@section('content')
@if(Auth::user()->role === 'admin')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Skema Sertifikasi</h3>
    <a href="{{ route('skema.create') }}" class="btn btn-primary">+ Tambah Skema</a>
</div>

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

        {{ $skemas->links() }}
    </div>
</div>
@endif
@endsection