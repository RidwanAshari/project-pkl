@extends('layouts.app')

@section('title', 'Tambah Data Pemeliharaan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Pemeliharaan</h1>
        <a href="{{ route('vehicles.show', $asset) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('vehicles.store-maintenance', $asset) }}" method="POST" enctype="multipart/form-data" id="maintenanceForm">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Servis <span class="text-danger">*</span></label>
                                <select name="jenis_servis" id="jenis_servis" class="form-select @error('jenis_servis') is-invalid @enderror" required>
                                    <option value="">Pilih Jenis Servis</option>
                                    <option value="Pengisian BBM" {{ old('jenis_servis') == 'Pengisian BBM' ? 'selected' : '' }}>Pengisian BBM</option>
                                    <option value="Service Rutin" {{ old('jenis_servis') == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>
                                    <option value="Perbaikan" {{ old('jenis_servis') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                    <option value="Penggantian" {{ old('jenis_servis') == 'Penggantian' ? 'selected' : '' }}>Penggantian</option>
                                    <option value="Bayar Pajak" {{ old('jenis_servis') == 'Bayar Pajak' ? 'selected' : '' }}>Bayar Pajak</option>
                                </select>
                                @error('jenis_servis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- ========= FORM BBM ========= --}}
                        <div id="form-bbm" style="display: none;">
                            <div class="alert alert-info">
                                <strong><i class="fas fa-gas-pump me-2"></i>Form Pengisian BBM</strong>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Jenis BBM</label>
                                    <select name="jenis_bbm" class="form-select">
                                        <option value="">Pilih BBM</option>
                                        <option value="Pertalite" {{ old('jenis_bbm') == 'Pertalite' ? 'selected' : '' }}>Pertalite</option>
                                        <option value="Pertamax" {{ old('jenis_bbm') == 'Pertamax' ? 'selected' : '' }}>Pertamax</option>
                                        <option value="Pertamax Turbo" {{ old('jenis_bbm') == 'Pertamax Turbo' ? 'selected' : '' }}>Pertamax Turbo</option>
                                        <option value="Solar" {{ old('jenis_bbm') == 'Solar' ? 'selected' : '' }}>Solar</option>
                                        <option value="Dex" {{ old('jenis_bbm') == 'Dex' ? 'selected' : '' }}>Dex</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jumlah (Liter)</label>
                                    <input type="number" step="0.01" name="jumlah_liter" id="jumlah_liter" class="form-control" value="{{ old('jumlah_liter') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Harga per Liter</label>
                                    <input type="number" name="harga_per_liter" id="harga_per_liter" class="form-control" value="{{ old('harga_per_liter') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Odometer (KM)</label>
                                    <input type="number" name="odometer" class="form-control" placeholder="Contoh: 45000" value="{{ old('odometer') }}">
                                </div>
                            </div>
                            {{-- Biaya & Nota untuk BBM --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Biaya <span class="text-danger">*</span></label>
                                    <input type="number" name="biaya" id="biaya-bbm" class="form-control" value="{{ old('biaya') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Upload Nota/Bukti</label>
                                    <input type="file" name="file_nota" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Format: PDF, JPG, PNG (Max 2MB)</small>
                                </div>
                            </div>
                        </div>

                        {{-- ========= FORM SERVICE RUTIN / PERBAIKAN / PENGGANTIAN ========= --}}
                        {{-- Tanpa biaya dan tanpa nota --}}
                        <div id="form-service" style="display: none;">
                            <div class="alert alert-success">
                                <strong><i class="fas fa-wrench me-2"></i>Form Service/Perbaikan/Penggantian</strong>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3"
                                    placeholder="Jelaskan detail pekerjaan...">{{ old('keterangan') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bengkel/Tempat Service</label>
                                <input type="text" name="bengkel" class="form-control"
                                    placeholder="Contoh: Bengkel ABC" value="{{ old('bengkel') }}">
                            </div>
                            {{-- Tidak ada kolom biaya dan tidak ada upload nota --}}
                        </div>

                        {{-- ========= FORM PAJAK ========= --}}
                        <div id="form-pajak" style="display: none;">
                            <div class="alert alert-warning">
                                <strong><i class="fas fa-file-invoice me-2"></i>Form Pembayaran Pajak</strong>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2"
                                    placeholder="Contoh: Pajak tahun 2026">{{ old('keterangan') }}</textarea>
                            </div>
                            {{-- Biaya & Nota untuk Pajak --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Biaya <span class="text-danger">*</span></label>
                                    <input type="number" name="biaya" id="biaya-pajak" class="form-control" value="{{ old('biaya') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Upload Nota/Bukti</label>
                                    <input type="file" name="file_nota" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Format: PDF, JPG, PNG (Max 2MB)</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="btn-submit" style="display:none;">
                                <i class="fas fa-save"></i> Simpan Data Pemeliharaan
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
const jenisServis = document.getElementById('jenis_servis');

jenisServis.addEventListener('change', function() {
    const jenis = this.value;

    // Sembunyikan semua
    document.getElementById('form-bbm').style.display    = 'none';
    document.getElementById('form-service').style.display = 'none';
    document.getElementById('form-pajak').style.display  = 'none';
    document.getElementById('btn-submit').style.display  = 'none';

    if (jenis === 'Pengisian BBM') {
        document.getElementById('form-bbm').style.display = 'block';
        document.getElementById('btn-submit').style.display = 'block';

    } else if (jenis === 'Bayar Pajak') {
        document.getElementById('form-pajak').style.display = 'block';
        document.getElementById('btn-submit').style.display = 'block';

    } else if (jenis !== '') {
        // Service Rutin, Perbaikan, Penggantian — tanpa biaya & nota
        document.getElementById('form-service').style.display = 'block';
        document.getElementById('btn-submit').style.display = 'block';
    }
});

// Auto-calculate biaya dari BBM
document.getElementById('jumlah_liter').addEventListener('input', calculateBBM);
document.getElementById('harga_per_liter').addEventListener('input', calculateBBM);

function calculateBBM() {
    const liter = parseFloat(document.getElementById('jumlah_liter').value) || 0;
    const harga = parseFloat(document.getElementById('harga_per_liter').value) || 0;
    const total = liter * harga;
    if (total > 0) {
        document.getElementById('biaya-bbm').value = total;
    }
}

// Trigger saat halaman load jika ada old value
if (jenisServis.value) {
    jenisServis.dispatchEvent(new Event('change'));
}
</script>
@endpush
@endsection