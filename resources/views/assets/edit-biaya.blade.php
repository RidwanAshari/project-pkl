@extends('layouts.app')
@section('title', 'Edit Aset Biaya')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Aset Biaya</h1>
        <a href="{{ route('assets-biaya.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                    @endif
                    <form action="{{ route('assets-biaya.update', $asset) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Kode Aset</label>
                                <input type="text" name="kode_aset" class="form-control @error('kode_aset') is-invalid @enderror" value="{{ old('kode_aset', $asset->kode_aset) }}">
                                @error('kode_aset')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Aset <span class="text-danger">*</span></label>
                                <input type="text" name="nama_aset" class="form-control @error('nama_aset') is-invalid @enderror" value="{{ old('nama_aset', $asset->nama_aset) }}" required>
                                @error('nama_aset')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach(['Bangunan','Tanah','Kendaraan','Peralatan','Inventaris Barang dan Perabot Kantor'] as $k)
                                    <option value="{{ $k }}" {{ old('kategori',$asset->kategori)==$k?'selected':'' }}>{{ $k }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-select" required>
                                    @foreach(['Baik','Rusak Ringan','Rusak Berat'] as $k)
                                    <option value="{{ $k }}" {{ old('kondisi',$asset->kondisi)==$k?'selected':'' }}>{{ $k }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Merk</label>
                                <input type="text" name="merk" class="form-control" value="{{ old('merk', $asset->merk) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipe</label>
                                <input type="text" name="tipe" class="form-control" value="{{ old('tipe', $asset->tipe) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tahun Perolehan <span class="text-danger">*</span></label>
                                <input type="number" name="tahun_perolehan" class="form-control" value="{{ old('tahun_perolehan', $asset->tahun_perolehan) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nilai Perolehan <span class="text-danger">*</span></label>
                                <input type="number" name="nilai_perolehan" class="form-control" value="{{ old('nilai_perolehan', $asset->nilai_perolehan) }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $asset->lokasi) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pemegang Saat Ini</label>
                                <input type="text" name="pemegang_saat_ini" class="form-control" value="{{ old('pemegang_saat_ini', $asset->pemegang_saat_ini) }}">
                                <small class="text-muted">Gunakan Transfer untuk ganti pemegang resmi</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Aset</label>
                            @if($asset->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $asset->foto) }}" style="max-height:120px;" class="rounded">
                                <p class="text-muted small mt-1">Upload baru untuk mengganti</p>
                            </div>
                            @endif
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $asset->keterangan) }}</textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Aset Biaya</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection