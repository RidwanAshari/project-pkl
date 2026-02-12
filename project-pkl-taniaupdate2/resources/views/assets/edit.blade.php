@extends('layouts.app')

@section('title', 'Edit Aset')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Aset</h1>
        <a href="{{ route('assets.show', $asset) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('assets.update', $asset) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Kode Aset <span class="text-danger">*</span></label>
                                <input type="text" name="kode_aset" class="form-control @error('kode_aset') is-invalid @enderror" value="{{ old('kode_aset', $asset->kode_aset) }}" required>
                                @error('kode_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Aset <span class="text-danger">*</span></label>
                                <input type="text" name="nama_aset" class="form-control @error('nama_aset') is-invalid @enderror" value="{{ old('nama_aset', $asset->nama_aset) }}" required>
                                @error('nama_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Bangunan" {{ old('kategori', $asset->kategori) == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                                    <option value="Tanah" {{ old('kategori', $asset->kategori) == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                                    <option value="Kendaraan" {{ old('kategori', $asset->kategori) == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                                    <option value="Peralatan" {{ old('kategori', $asset->kategori) == 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                                    <option value="Investasi" {{ old('kategori', $asset->kategori) == 'Investasi' ? 'selected' : '' }}>Investasi</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                    <option value="">Pilih Kondisi</option>
                                    <option value="Baik" {{ old('kondisi', $asset->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ old('kondisi', $asset->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi', $asset->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Merk</label>
                                <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" value="{{ old('merk', $asset->merk) }}">
                                @error('merk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipe</label>
                                <input type="text" name="tipe" class="form-control @error('tipe') is-invalid @enderror" value="{{ old('tipe', $asset->tipe) }}">
                                @error('tipe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tahun Perolehan <span class="text-danger">*</span></label>
                                <input type="number" name="tahun_perolehan" class="form-control @error('tahun_perolehan') is-invalid @enderror" value="{{ old('tahun_perolehan', $asset->tahun_perolehan) }}" required>
                                @error('tahun_perolehan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nilai Perolehan <span class="text-danger">*</span></label>
                                <input type="number" name="nilai_perolehan" class="form-control @error('nilai_perolehan') is-invalid @enderror" value="{{ old('nilai_perolehan', $asset->nilai_perolehan) }}" required>
                                @error('nilai_perolehan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi', $asset->lokasi) }}" required>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pemegang Saat Ini</label>
                                <input type="text" name="pemegang_saat_ini" class="form-control @error('pemegang_saat_ini') is-invalid @enderror" value="{{ old('pemegang_saat_ini', $asset->pemegang_saat_ini) }}">
                                <small class="text-muted">Untuk ganti pemegang, gunakan fitur Transfer di halaman detail</small>
                                @error('pemegang_saat_ini')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Aset</label>
                            @if($asset->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $asset->foto) }}" alt="Foto saat ini" style="max-height: 150px;" class="rounded">
                                    <p class="text-muted small">Foto saat ini (upload foto baru untuk mengganti)</p>
                                </div>
                            @endif
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan', $asset->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Aset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection