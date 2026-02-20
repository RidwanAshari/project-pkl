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

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('vehicles.maintenance.store', $asset) }}" method="POST" enctype="multipart/form-data" id="mainForm">
                        @csrf

                        {{-- Info Kendaraan --}}
                        <div class="alert alert-info">
                            <strong><i class="fas fa-car"></i> {{ $asset->nama_aset }}</strong><br>
                            <small>{{ $asset->merk }} {{ $asset->tipe }} - {{ $asset->vehicleDetail->nomor_plat ?? '-' }}</small>
                        </div>

                        {{-- Tanggal & Jenis Servis --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Servis <span class="text-danger">*</span></label>
                                <select name="jenis_servis" id="jenis_servis" class="form-select" required>
                                    <option value="">-- Pilih Jenis Servis --</option>
                                    <option value="Pengisian BBM">Pengisian BBM</option>
                                    <option value="Service Rutin">Service Rutin</option>
                                    <option value="Perbaikan">Perbaikan</option>
                                    <option value="Penggantian">Penggantian</option>
                                    <option value="Bayar Pajak">Bayar Pajak</option>
                                </select>
                            </div>
                        </div>

                        {{-- Form BBM --}}
                        <div id="fields-bbm" style="display: none;">
                            <hr><h6 class="text-primary">Detail Pengisian BBM</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Jenis BBM</label>
                                    <select name="jenis_bbm" class="form-select">
                                        <option value="">Pilih BBM</option>
                                        <option value="Pertalite">Pertalite</option>
                                        <option value="Pertamax">Pertamax</option>
                                        <option value="Pertamax Turbo">Pertamax Turbo</option>
                                        <option value="Solar">Solar</option>
                                        <option value="Dex">Dex</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jumlah (Liter)</label>
                                    <input type="number" step="0.01" name="jumlah_liter" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Harga per Liter</label>
                                    <input type="number" name="harga_per_liter" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Odometer (KM)</label>
                                    <input type="number" name="odometer" class="form-control" placeholder="Contoh: 45000">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Biaya Total <span class="text-danger">*</span></label>
                                    <input type="number" name="biaya_bbm" id="biaya-bbm" class="form-control" placeholder="Masukkan biaya total">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload Nota/Bukti</label>
                                <input type="file" name="file_nota" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format: PDF, JPG, PNG (Max 2MB)</small>
                            </div>
                        </div>

                        {{-- Form Service --}}
                        <div id="fields-service" style="display: none;">
                            <hr><h6 class="text-success">Detail Service/Perbaikan/Penggantian</h6>
                            <div class="mb-3">
                                <label class="form-label">Bengkel/Tempat Service</label>
                                <select name="bengkel" class="form-select">
                                    <option value="">-- Pilih Bengkel --</option>
                                    @foreach($bengkels as $bengkel)
                                        <option value="{{ $bengkel->nama }}">{{ $bengkel->nama }} - {{ $bengkel->alamat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan / Suku Cadang <span class="text-danger">*</span></label>
                                <textarea name="keterangan" id="keterangan-field" class="form-control" rows="5" placeholder="Format untuk surat pengantar (pisahkan dengan ENTER):

OLI MESIN|1|LT
ban belakang luar dan dalam|1|set
filter udara|1|pcs

Atau tulis keterangan biasa tanpa format."></textarea>
                                <small class="text-muted"><i class="fas fa-info-circle"></i> Format: <code>Uraian|Jumlah|Satuan</code></small>
                            </div>
                        </div>

                        {{-- Form Pajak --}}
                        <div id="fields-pajak" style="display: none;">
                            <hr><h6 class="text-danger">Detail Pembayaran Pajak</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Pajak</label>
                                    <input type="text" name="jenis_pajak" class="form-control" placeholder="Contoh: Pajak Kendaraan Tahunan">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Biaya <span class="text-danger">*</span></label>
                                    <input type="number" name="biaya_pajak" id="biaya-pajak" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload Nota/Bukti</label>
                                <input type="file" name="file_nota" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format: PDF, JPG, PNG (Max 2MB)</small>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4" id="submit-wrapper" style="display:none;">
                            <button type="submit" class="btn btn-primary btn-lg">
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
document.addEventListener('DOMContentLoaded', function() {
    const jenisServis = document.getElementById('jenis_servis');
    const fieldsBBM = document.getElementById('fields-bbm');
    const fieldsService = document.getElementById('fields-service');
    const fieldsPajak = document.getElementById('fields-pajak');
    const submitWrapper = document.getElementById('submit-wrapper');
    
    // Field biaya untuk BBM
    const biayaBBMInput = document.getElementById('biaya-bbm');
    
    // Field biaya untuk Pajak
    const biayaPajakInput = document.getElementById('biaya-pajak');
    
    // Field keterangan untuk Service
    const keteranganInput = document.getElementById('keterangan-field');

    jenisServis.addEventListener('change', function() {
        const jenis = this.value;
        
        // Hide all & remove required
        fieldsBBM.style.display = 'none';
        fieldsService.style.display = 'none';
        fieldsPajak.style.display = 'none';
        submitWrapper.style.display = 'none';
        
        if (biayaBBMInput) biayaBBMInput.removeAttribute('required');
        if (biayaPajakInput) biayaPajakInput.removeAttribute('required');
        if (keteranganInput) keteranganInput.removeAttribute('required');
        
        if (jenis === 'Pengisian BBM') {
            fieldsBBM.style.display = 'block';
            submitWrapper.style.display = 'block';
            if (biayaBBMInput) biayaBBMInput.setAttribute('required', 'required');
            
        } else if (jenis === 'Bayar Pajak') {
            fieldsPajak.style.display = 'block';
            submitWrapper.style.display = 'block';
            if (biayaPajakInput) biayaPajakInput.setAttribute('required', 'required');
            
        } else if (jenis !== '') {
            // Service Rutin, Perbaikan, Penggantian
            fieldsService.style.display = 'block';
            submitWrapper.style.display = 'block';
            if (keteranganInput) keteranganInput.setAttribute('required', 'required');
        }
    });
    
    // Trigger on load if old value
    if (jenisServis.value) {
        jenisServis.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection