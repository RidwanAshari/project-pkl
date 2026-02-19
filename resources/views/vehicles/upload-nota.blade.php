@extends('layouts.app')

@section('title', 'Upload Nota')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-gray-800">
            Upload Nota - {{ $asset->nama_aset }}
        </h1>
        <a href="{{ route('vehicles.show', $asset) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('vehicles.store-nota', [$asset->id, $maintenance->id]) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Upload File Nota</label>
                    <input type="file"
                           name="file_nota"
                           class="form-control"
                           accept=".jpg,.jpeg,.png,.pdf"
                           required>
                    <small class="text-muted">
                        Format: JPG, PNG, PDF (Max 2MB)
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Nota
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
