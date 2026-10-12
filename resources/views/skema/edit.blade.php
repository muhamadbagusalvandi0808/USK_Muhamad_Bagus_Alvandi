@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Edit Skema Sertifikasi</h5>
            </div>
            <div class="card-body">

                {{-- Tampilkan Error Validasi --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('skema.update', $skema->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Kode Skema</label>
                        <input type="text" name="kd_skema" class="form-control" value="{{ old('kd_skema', $skema->kd_skema) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Skema</label>
                        <input type="text" name="nm_skema" class="form-control" value="{{ old('nm_skema', $skema->nm_skema) }}" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('skema.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection