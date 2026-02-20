@extends('layouts.app')

@section('title', 'Tambah Aset')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Aset Baru</h1>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Kode Aset <span class="text-danger">*</span></label>
                                <input type="text" name="kode_aset" class="form-control @error('kode_aset') is-invalid @enderror" value="{{ old('kode_aset') }}" required>
                                @error('kode_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Aset <span class="text-danger">*</span></label>
                                <input type="text" name="nama_aset" class="form-control @error('nama_aset') is-invalid @enderror" value="{{ old('nama_aset') }}" required>
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
                                    <option value="Bangunan" {{ old('kategori') == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                                    <option value="Tanah" {{ old('kategori') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                                    <option value="Kendaraan" {{ old('kategori') == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                                    <option value="Peralatan" {{ old('kategori') == 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                                    <option value="Investasi" {{ old('kategori') == 'Investasi' ? 'selected' : '' }}>Investasi</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                    <option value="">Pilih Kondisi</option>
                                    <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Merk</label>
                                <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" value="{{ old('merk') }}">
                                @error('merk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipe</label>
                                <input type="text" name="tipe" class="form-control @error('tipe') is-invalid @enderror" value="{{ old('tipe') }}">
                                @error('tipe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tahun Perolehan <span class="text-danger">*</span></label>
                                <input type="number" name="tahun_perolehan" class="form-control @error('tahun_perolehan') is-invalid @enderror" value="{{ old('tahun_perolehan', date('Y')) }}" required>
                                @error('tahun_perolehan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nilai Perolehan <span class="text-danger">*</span></label>
                                <input type="number" name="nilai_perolehan" class="form-control @error('nilai_perolehan') is-invalid @enderror" value="{{ old('nilai_perolehan') }}" required>
                                @error('nilai_perolehan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" required>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pemegang Saat Ini</label>
                                <select name="pemegang_saat_ini" class="form-select" id="select_pemegang">
                                    <option value="">-- Pilih Pemegang --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->name }}"
                                            data-jabatan="{{ $user->position ?? '' }}"
                                            data-nipp="{{ $user->username ?? '' }}"
                                            {{ old('pemegang_saat_ini') == $user->name ? 'selected' : '' }}>
                                            {{ $user->name }}{{ $user->position ? ' - '.ucfirst($user->position) : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Data pemegang untuk berita acara penerimaan awal --}}
                        <div class="row mb-3" id="pemegang-detail" style="display:none;">
                            <div class="col-md-5">
                                <label class="form-label">Jabatan Pemegang</label>
                                <select name="jabatan_pemegang" id="jabatan_pemegang" class="form-select">
                                    <option value="">-- Pilih Jabatan --</option>
                                    <option value="Direktur Utama">Direktur Utama</option>
                                    <option value="Direktur">Direktur</option>
                                    <option value="Ka Sub Bag Umum & PDE">Ka Sub Bag Umum &amp; PDE</option>
                                    <option value="Ka Sub Bag Keuangan">Ka Sub Bag Keuangan</option>
                                    <option value="Ka Sub Bag SDM">Ka Sub Bag SDM</option>
                                    <option value="Ka Sub Unit Banjarnegoro">Ka Sub Unit Banjarnegoro</option>
                                    <option value="Ka Sub Unit Mertoyudan">Ka Sub Unit Mertoyudan</option>
                                    <option value="Ka Sub Unit Muntilan">Ka Sub Unit Muntilan</option>
                                    <option value="Ka Sub Unit Grabag">Ka Sub Unit Grabag</option>
                                    <option value="Plt. Ka Sub Unit Banjarnegoro">Plt. Ka Sub Unit Banjarnegoro</option>
                                    <option value="Plt. Ka Sub Unit Mertoyudan">Plt. Ka Sub Unit Mertoyudan</option>
                                    <option value="Staf Umum">Staf Umum</option>
                                    <option value="Staf Keuangan">Staf Keuangan</option>
                                    <option value="Staf Teknik">Staf Teknik</option>
                                    <option value="Bagian Pengadaan">Bagian Pengadaan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Alamat Pemegang</label>
                                <input type="text" name="alamat_pemegang" class="form-control" placeholder="Contoh: Jl. Soekarno Hatta No.2" value="{{ old('alamat_pemegang') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">NIPP Pemegang</label>
                                <input type="text" name="nipp_pemegang" id="nipp_pemegang" class="form-control" placeholder="Contoh: 1912.0606.83" value="{{ old('nipp_pemegang') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Aset</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Khusus Kendaraan (tampil jika kategori = Kendaraan) -->
                        <div id="vehicle-form" style="display: none;">
                            <hr class="my-4">
                            <h5 class="text-primary mb-3">Detail Kendaraan</h5>
                            
                            {{-- Field nama/jabatan/alamat pemilik dihapus karena sudah diisi di bagian "Pemegang Saat Ini" --}}
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Plat</label>
                                    <input type="text" name="nomor_plat" class="form-control" placeholder="Contoh: B 1234 XYZ" value="{{ old('nomor_plat') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Model</label>
                                    <input type="text" name="model" class="form-control" placeholder="Contoh: Sedan" value="{{ old('model') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Model</label>
                                    <input type="text" name="model" class="form-control" value="{{ old('model') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tahun Pembuatan</label>
                                    <input type="number" name="tahun_pembuatan" class="form-control" value="{{ old('tahun_pembuatan') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Isi Silinder</label>
                                    <input type="text" name="isi_silinder" class="form-control" placeholder="Contoh: 1500 CC" value="{{ old('isi_silinder') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Rangka</label>
                                    <input type="text" name="nomor_rangka" class="form-control" value="{{ old('nomor_rangka') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Mesin</label>
                                    <input type="text" name="nomor_mesin" class="form-control" value="{{ old('nomor_mesin') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Warna</label>
                                    <input type="text" name="warna" class="form-control" value="{{ old('warna') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Bahan Bakar</label>
                                    <select name="bahan_bakar" class="form-select">
                                        <option value="">Pilih</option>
                                        <option value="Bensin">Bensin</option>
                                        <option value="Solar">Solar</option>
                                        <option value="Listrik">Listrik</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nomor BPKB</label>
                                    <input type="text" name="nomor_bpkb" class="form-control" value="{{ old('nomor_bpkb') }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Aset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelector('select[name="kategori"]').addEventListener('change', function() {
    const vehicleForm = document.getElementById('vehicle-form');
    if (this.value === 'Kendaraan') {
        vehicleForm.style.display = 'block';
    } else {
        vehicleForm.style.display = 'none';
    }
});

// Trigger on page load if old value
if (document.querySelector('select[name="kategori"]').value === 'Kendaraan') {
    document.getElementById('vehicle-form').style.display = 'block';
}

// Tampilkan field detail pemegang saat pemegang dipilih
const selectPemegang = document.getElementById('select_pemegang');
if (selectPemegang) {
    selectPemegang.addEventListener('change', function() {
        const detail = document.getElementById('pemegang-detail');
        if (this.value) {
            detail.style.display = 'flex';
        } else {
            detail.style.display = 'none';
        }
    });
    // Trigger on load jika ada old value
    if (selectPemegang.value) {
        document.getElementById('pemegang-detail').style.display = 'flex';
    }
}
</script>
@endpush
@endsection