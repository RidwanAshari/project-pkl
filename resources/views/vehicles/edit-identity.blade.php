@extends('layouts.app')

@section('title', 'Edit Identitas Kendaraan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Identitas Kendaraan</h1>
        <a href="{{ route('vehicles.show', $asset) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('vehicles.update-identity', $asset) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="text-primary mb-3">Identitas Pemilik/Pengguna</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Pemilik/Pengguna</label>
                        <input type="text" name="nama_pemilik" class="form-control" value="{{ old('nama_pemilik', $vehicleDetail->nama_pemilik) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $vehicleDetail->jabatan) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="1">{{ old('alamat', $vehicleDetail->alamat) }}</textarea>
                    </div>
                </div>

                <hr>
                <h5 class="text-primary mb-3">Spesifikasi Kendaraan</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Plat</label>
                        <input type="text" name="nomor_plat" class="form-control" placeholder="Contoh: B 1234 XYZ" value="{{ old('nomor_plat', $vehicleDetail->nomor_plat) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Model</label>
                        <input type="text" name="model" class="form-control" value="{{ old('model', $vehicleDetail->model) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Tahun Pembuatan</label>
                        <input type="number" name="tahun_pembuatan" class="form-control" value="{{ old('tahun_pembuatan', $vehicleDetail->tahun_pembuatan) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Isi Silinder</label>
                        <input type="text" name="isi_silinder" class="form-control" placeholder="Contoh: 1500 CC" value="{{ old('isi_silinder', $vehicleDetail->isi_silinder) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Nomor Rangka</label>
                        <input type="text" name="nomor_rangka" class="form-control" value="{{ old('nomor_rangka', $vehicleDetail->nomor_rangka) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nomor Mesin</label>
                        <input type="text" name="nomor_mesin" class="form-control" value="{{ old('nomor_mesin', $vehicleDetail->nomor_mesin) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Warna</label>
                        <input type="text" name="warna" class="form-control" value="{{ old('warna', $vehicleDetail->warna) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Bahan Bakar</label>
                        <select name="bahan_bakar" class="form-select">
                            <option value="">Pilih Bahan Bakar</option>
                            <option value="Bensin" {{ old('bahan_bakar', $vehicleDetail->bahan_bakar) == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                            <option value="Solar" {{ old('bahan_bakar', $vehicleDetail->bahan_bakar) == 'Solar' ? 'selected' : '' }}>Solar</option>
                            <option value="Listrik" {{ old('bahan_bakar', $vehicleDetail->bahan_bakar) == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                            <option value="Hybrid" {{ old('bahan_bakar', $vehicleDetail->bahan_bakar) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Berat (KG)</label>
                        <input type="number" step="0.01" name="berat" class="form-control" value="{{ old('berat', $vehicleDetail->berat) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jumlah Sumbu</label>
                        <input type="number" name="sumbu" class="form-control" value="{{ old('sumbu', $vehicleDetail->sumbu) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Kapasitas Penumpang</label>
                        <input type="number" name="penumpang" class="form-control" value="{{ old('penumpang', $vehicleDetail->penumpang) }}">
                    </div>
                </div>

                <hr>
                <h5 class="text-primary mb-3">Data STNK/BPKB</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Warna TNKB</label>
                        <input type="text" name="warna_tnkb" class="form-control" placeholder="Contoh: Hitam" value="{{ old('warna_tnkb', $vehicleDetail->warna_tnkb) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tahun Registrasi</label>
                        <input type="number" name="tahun_registrasi" class="form-control" value="{{ old('tahun_registrasi', $vehicleDetail->tahun_registrasi) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nomor BPKB</label>
                        <input type="text" name="nomor_bpkb" class="form-control" value="{{ old('nomor_bpkb', $vehicleDetail->nomor_bpkb) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Berlaku STNK</label>
                        <input type="date" name="tanggal_berlaku" class="form-control" value="{{ old('tanggal_berlaku', $vehicleDetail->tanggal_berlaku ? $vehicleDetail->tanggal_berlaku->format('Y-m-d') : '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bulan Berlaku</label>
                        <select name="bulan_berlaku" class="form-select">
                            <option value="">Pilih Bulan</option>
                            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan)
                            <option value="{{ $bulan }}" {{ old('bulan_berlaku', $vehicleDetail->bulan_berlaku) == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tahun Berlaku</label>
                        <input type="text" name="tahun_berlaku" class="form-control" placeholder="Contoh: 2025" value="{{ old('tahun_berlaku', $vehicleDetail->tahun_berlaku) }}">
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Identitas Kendaraan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection