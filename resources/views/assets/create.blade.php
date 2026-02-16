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
                                {{-- TASK 2: "Investasi" diganti "Inventaris Barang dan Perabot Kantor" --}}
                                <select name="kategori" id="select-kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Bangunan" {{ old('kategori') == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                                    <option value="Tanah" {{ old('kategori') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                                    <option value="Kendaraan" {{ old('kategori') == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                                    <option value="Peralatan" {{ old('kategori') == 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                                    <option value="Inventaris Barang dan Perabot Kantor" {{ old('kategori') == 'Inventaris Barang dan Perabot Kantor' ? 'selected' : '' }}>Inventaris Barang dan Perabot Kantor</option>
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
                                {{-- TASK 4: Pemegang Saat Ini jadi dropdown dari data users --}}
                                <label class="form-label">Pemegang Saat Ini</label>
                                <select name="pemegang_saat_ini" id="select-pemegang" class="form-select @error('pemegang_saat_ini') is-invalid @enderror">
                                    <option value="">-- Pilih Pemegang --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->name }}" {{ old('pemegang_saat_ini') == $user->name ? 'selected' : '' }}>
                                            {{ $user->name }}{{ $user->position ? ' - ' . ucfirst($user->position) : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pemegang_saat_ini')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    {{-- TASK 4: Nama Pemilik jadi dropdown dari data users --}}
                                    <label class="form-label">Nama Pemilik/Pengguna</label>
                                    <select name="nama_pemilik" id="select-nama-pemilik" class="form-select">
                                        <option value="">-- Pilih Pemilik --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->name }}"
                                                data-jabatan="{{ $user->position ?? '' }}"
                                                {{ old('nama_pemilik') == $user->name ? 'selected' : '' }}>
                                                {{ $user->name }}{{ $user->position ? ' - ' . ucfirst($user->position) : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    {{-- TASK 4: Jabatan jadi dropdown, auto-fill dari pilihan nama pemilik --}}
                                    <label class="form-label">Jabatan</label>
                                    <select name="jabatan" id="select-jabatan" class="form-select">
                                        <option value="">-- Pilih Jabatan --</option>
                                        <option value="Direktur" {{ old('jabatan') == 'Direktur' ? 'selected' : '' }}>Direktur</option>
                                        <option value="Manager" {{ old('jabatan') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="Supervisor" {{ old('jabatan') == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                                        <option value="Staff" {{ old('jabatan') == 'Staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="Admin" {{ old('jabatan') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Operator" {{ old('jabatan') == 'Operator' ? 'selected' : '' }}>Operator</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Plat</label>
                                    <input type="text" name="nomor_plat" class="form-control" placeholder="Contoh: B 1234 XYZ" value="{{ old('nomor_plat') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="1">{{ old('alamat') }}</textarea>
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
                                        <option value="Bensin" {{ old('bahan_bakar') == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                                        <option value="Solar" {{ old('bahan_bakar') == 'Solar' ? 'selected' : '' }}>Solar</option>
                                        <option value="Listrik" {{ old('bahan_bakar') == 'Listrik' ? 'selected' : '' }}>Listrik</option>
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
// Tampilkan form kendaraan jika kategori = Kendaraan
document.getElementById('select-kategori').addEventListener('change', function() {
    const vehicleForm = document.getElementById('vehicle-form');
    vehicleForm.style.display = (this.value === 'Kendaraan') ? 'block' : 'none';
});

// Trigger on page load jika old value = Kendaraan
if (document.getElementById('select-kategori').value === 'Kendaraan') {
    document.getElementById('vehicle-form').style.display = 'block';
}

// Auto-fill jabatan saat nama pemilik dipilih
document.getElementById('select-nama-pemilik').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const jabatan = selectedOption.getAttribute('data-jabatan');
    const selectJabatan = document.getElementById('select-jabatan');

    if (jabatan) {
        // Cari option yang cocok (case-insensitive)
        for (let i = 0; i < selectJabatan.options.length; i++) {
            if (selectJabatan.options[i].value.toLowerCase() === jabatan.toLowerCase()) {
                selectJabatan.selectedIndex = i;
                return;
            }
        }
    }
    // Kalau tidak ada yang cocok, reset ke kosong
    selectJabatan.selectedIndex = 0;
});
</script>
@endpush
@endsection