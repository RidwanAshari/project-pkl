@extends('layouts.app')

@section('title', 'Input Biaya Servis')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Input Biaya Aktual Servis</h1>
        <a href="{{ route('vehicles.show', $asset) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-check-circle"></i> Surat Pengantar Telah Disetujui Kabag
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <strong>Kendaraan:</strong> {{ $asset->nama_aset }}<br>
                        <strong>Jenis Servis:</strong> {{ $maintenance->jenis_servis }}<br>
                        <strong>Bengkel:</strong> {{ $maintenance->bengkel ?? '-' }}<br>
                        <strong>Disetujui oleh:</strong> {{ $maintenance->approved_by ?? '-' }} pada {{ $maintenance->approved_at ? $maintenance->approved_at->format('d/m/Y H:i') : '-' }}
                    </div>

                    @if($maintenance->file_surat_ttd)
                    <div class="mb-4">
                        <a href="{{ asset('storage/' . $maintenance->file_surat_ttd) }}" target="_blank" class="btn btn-outline-success">
                            <i class="fas fa-file-pdf"></i> Lihat Surat Pengantar yang Sudah Ditandatangani
                        </a>
                    </div>
                    @endif

                    <form action="{{ route('finance.input-biaya', $maintenance) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Biaya Aktual (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="biaya_aktual" class="form-control form-control-lg" min="0" required
                                placeholder="Masukkan total biaya dari nota bengkel">
                            <small class="text-muted">Sesuai dengan nota yang diterima dari bengkel</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Nota Bengkel <span class="text-danger">*</span></label>
                            <input type="file" name="file_nota_bengkel" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted">Format: PDF / Gambar. Maks 5MB</small>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" onclick="return confirm('Konfirmasi pengiriman biaya dan nota ke Finance?')">
                                <i class="fas fa-paper-plane"></i> Kirim ke Finance untuk Pembuatan DPB
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
