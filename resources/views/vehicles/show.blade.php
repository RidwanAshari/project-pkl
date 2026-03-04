@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kendaraan: {{ $asset->nama_aset }}</h1>
        <div>
            <a href="{{ route('assets.show', $asset) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#identitas">
                <i class="fas fa-id-card"></i> Identitas Kendaraan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#pemeliharaan">
                <i class="fas fa-wrench"></i> Data Pemeliharaan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#statistik">
                <i class="fas fa-chart-pie"></i> Statistik Biaya
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#penyusutan">
                <i class="fas fa-chart-line"></i> Penyusutan
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Tab Identitas -->
        <div id="identitas" class="tab-pane fade show active">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Identitas Kendaraan</h6>
                    <a href="{{ route('vehicles.edit-identity', $asset) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit Identitas
                    </a>
                </div>
                <div class="card-body">
                    @if($vehicleDetail)
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr><td width="40%"><strong>Nama Pemilik/Pengguna</strong></td><td>{{ $vehicleDetail->nama_pemilik ?? '-' }}</td></tr>
                                <tr><td><strong>Jabatan</strong></td><td>{{ $vehicleDetail->jabatan ?? '-' }}</td></tr>
                                <tr><td><strong>Alamat</strong></td><td>{{ $vehicleDetail->alamat ?? '-' }}</td></tr>
                                <tr><td><strong>Nomor Plat</strong></td><td><span class="badge bg-dark">{{ $vehicleDetail->nomor_plat ?? '-' }}</span></td></tr>
                                <tr><td><strong>Merk</strong></td><td>{{ $asset->merk ?? '-' }}</td></tr>
                                <tr><td><strong>Type</strong></td><td>{{ $asset->tipe ?? '-' }}</td></tr>
                                <tr><td><strong>Model</strong></td><td>{{ $vehicleDetail->model ?? '-' }}</td></tr>
                                <tr><td><strong>Tahun Pembuatan</strong></td><td>{{ $vehicleDetail->tahun_pembuatan ?? '-' }}</td></tr>
                                <tr><td><strong>Isi Silinder</strong></td><td>{{ $vehicleDetail->isi_silinder ?? '-' }}</td></tr>
                                <tr><td><strong>Nomor Rangka</strong></td><td>{{ $vehicleDetail->nomor_rangka ?? '-' }}</td></tr>
                                <tr><td><strong>Nomor Mesin</strong></td><td>{{ $vehicleDetail->nomor_mesin ?? '-' }}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr><td width="40%"><strong>Warna</strong></td><td>{{ $vehicleDetail->warna ?? '-' }}</td></tr>
                                <tr><td><strong>Bahan Bakar</strong></td><td>{{ $vehicleDetail->bahan_bakar ?? '-' }}</td></tr>
                                <tr><td><strong>Warna TNKB</strong></td><td>{{ $vehicleDetail->warna_tnkb ?? '-' }}</td></tr>
                                <tr><td><strong>Tahun Registrasi</strong></td><td>{{ $vehicleDetail->tahun_registrasi ?? '-' }}</td></tr>
                                <tr><td><strong>Nomor BPKB</strong></td><td>{{ $vehicleDetail->nomor_bpkb ?? '-' }}</td></tr>
                                <tr><td><strong>Tanggal Berlaku</strong></td><td>{{ $vehicleDetail->tanggal_berlaku ? $vehicleDetail->tanggal_berlaku->format('d/m/Y') : '-' }}</td></tr>
                                <tr><td><strong>Berat (KG)</strong></td><td>{{ $vehicleDetail->berat ?? '-' }}</td></tr>
                                <tr><td><strong>Sumbu</strong></td><td>{{ $vehicleDetail->sumbu ?? '-' }}</td></tr>
                                <tr><td><strong>Penumpang</strong></td><td>{{ $vehicleDetail->penumpang ?? '-' }}</td></tr>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <p class="text-muted">Belum ada data identitas kendaraan</p>
                        <a href="{{ route('vehicles.edit-identity', $asset) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Identitas
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Pemeliharaan -->
        <div id="pemeliharaan" class="tab-pane fade">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pemeliharaan & Operasional</h6>
                    <a href="{{ route('vehicles.maintenance.create', $asset) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis Servis</th>
                                    <th>Detail</th>
                                    <th>Biaya</th>
                                    <th>Status Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asset->vehicleMaintenances as $m)
                                <tr>
                                    <td>{{ $m->tanggal->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($m->jenis_servis == 'Pengisian BBM') bg-info
                                            @elseif($m->jenis_servis == 'Service Rutin') bg-success
                                            @elseif($m->jenis_servis == 'Perbaikan') bg-warning
                                            @elseif($m->jenis_servis == 'Penggantian') bg-primary
                                            @else bg-danger @endif">
                                            {{ $m->jenis_servis }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($m->jenis_servis == 'Pengisian BBM')
                                            {{ $m->jenis_bbm }} - {{ $m->jumlah_liter }}L @ Rp{{ number_format($m->harga_per_liter, 0, ',', '.') }}
                                            <br><small class="text-muted">Odometer: {{ $m->odometer }} km</small>
                                        @else
                                            {{ $m->keterangan ?? '-' }}
                                            @if($m->bengkel)<br><small class="text-muted">{{ $m->bengkel }}</small>@endif
                                        @endif
                                    </td>
                                    <td class="fw-bold">
                                        @if($m->biaya_aktual)
                                            Rp {{ number_format($m->biaya_aktual, 0, ',', '.') }}
                                        @else
                                            Rp {{ number_format($m->biaya, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($m->status_surat === 'menunggu_acc')
                                            <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Menunggu Acc</span>
                                        @elseif($m->status_surat === 'menunggu_eko')
                                            <span class="badge bg-info text-dark"><i class="fas fa-user-check"></i> Menunggu Ka.Sub.bag.</span>
                                        @elseif($m->status_surat === 'disetujui')
                                            <span class="badge bg-success"><i class="fas fa-check"></i> Disetujui</span>
                                            @if($m->terkirim_ke_finance)
                                                <br><small class="text-success"><i class="fas fa-paper-plane"></i> Terkirim ke Finance</small>
                                            @endif
                                        @elseif($m->status_surat === 'ditolak')
                                            <span class="badge bg-danger"><i class="fas fa-times"></i> Ditolak</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Surat: hanya tampil jika sudah disetujui --}}
                                        @if($m->status_surat === 'disetujui' && $m->file_surat_ttd)
                                            <a href="{{ asset('storage/' . $m->file_surat_ttd) }}" target="_blank" class="btn btn-sm btn-success" title="Download Surat TTD">
                                                <i class="fas fa-file-pdf"></i> Surat
                                            </a>
                                        @elseif($m->status_surat === 'menunggu_acc')
                                            <span class="btn btn-sm btn-secondary disabled" title="Menunggu persetujuan Kabag">
                                                <i class="fas fa-hourglass-half"></i> Menunggu Acc
                                            </span>
                                        @elseif($m->status_surat === 'menunggu_eko')
                                            <span class="btn btn-sm btn-info disabled" title="Menunggu verifikasi Ka.Sub.bag.">
                                                <i class="fas fa-user-check"></i> Menunggu Ka.Sub.bag.
                                            </span>
                                        @endif

                                        {{-- Input biaya setelah disetujui (kedua pihak), sebelum ada biaya aktual --}}
                                        @if($m->status_surat === 'disetujui' && !$m->biaya_aktual)
                                            <a href="{{ route('vehicles.input-biaya', [$asset, $m]) }}" class="btn btn-sm btn-info" title="Input Biaya & Nota">
                                                <i class="fas fa-money-bill"></i> Input Biaya
                                            </a>
                                        @endif

                                        {{-- Nota bengkel jika sudah ada --}}
                                        @if($m->file_nota_bengkel)
                                            <a href="{{ asset('storage/' . $m->file_nota_bengkel) }}" target="_blank" class="btn btn-sm btn-secondary" title="Lihat Nota Bengkel">
                                                <i class="fas fa-receipt"></i>
                                            </a>
                                        @endif

                                        {{-- Nota awal --}}
                                        @if($m->file_nota)
                                            <a href="{{ asset('storage/' . $m->file_nota) }}" target="_blank" class="btn btn-sm btn-light border" title="Lihat Nota">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        @endif

                                        <form action="{{ route('vehicles.maintenance.delete', [$asset, $m]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data pemeliharaan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Statistik -->
        <div id="statistik" class="tab-pane fade">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-left-primary">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Biaya</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-left-info">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Biaya BBM</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($biayaBBM, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-left-success">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Biaya Service</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($biayaService, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-left-danger">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Biaya Pajak</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($biayaPajak, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rincian Biaya per Kategori</h6>
                </div>
                <div class="card-body">
                    <canvas id="costChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tab Penyusutan -->
        <div id="penyusutan" class="tab-pane fade">
            <div class="row">
                {{-- Kolom kiri: konfigurasi + tambah per tahun --}}
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Konfigurasi Penyusutan</h6>
                            @if($depreciation)
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#formKonfigurasi">
                                <i class="fas fa-cog"></i> Ubah
                            </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-3 p-3 bg-light rounded">
                                <small class="text-muted d-block">Nilai Perolehan</small>
                                <strong>Rp {{ number_format($asset->nilai_perolehan, 0, ',', '.') }}</strong>
                            </div>
                            @if($depreciation)
                            <div class="mb-3 p-3 bg-success bg-opacity-10 rounded border border-success">
                                <small class="text-muted d-block">Nilai Buku Saat Ini</small>
                                <strong class="text-success fs-5">Rp {{ number_format($nilaiSekarang, 0, ',', '.') }}</strong>
                                <small class="text-muted d-block mt-1">
                                    Disusutkan {{ round((($asset->nilai_perolehan - $nilaiSekarang) / max(1,$asset->nilai_perolehan)) * 100, 1) }}% dari nilai perolehan
                                </small>
                            </div>
                            @endif

                            {{-- Form konfigurasi --}}
                            <div class="{{ $depreciation ? 'collapse' : '' }}" id="formKonfigurasi">
                                @if($depreciation)<hr>@endif
                                <form action="{{ route('vehicles.save-depreciation', $asset) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Metode Penyusutan</label>
                                        <select name="metode" class="form-select" required>
                                            <option value="garis_lurus" {{ ($depreciation->metode ?? '') == 'garis_lurus' ? 'selected' : '' }}>Garis Lurus (Straight Line)</option>
                                            <option value="saldo_menurun" {{ ($depreciation->metode ?? '') == 'saldo_menurun' ? 'selected' : '' }}>Saldo Menurun (Declining Balance)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Umur Ekonomis (Tahun)</label>
                                        <input type="number" name="umur_ekonomis" class="form-control" min="1" max="100" value="{{ $depreciation->umur_ekonomis ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Nilai Sisa (Rp)</label>
                                        <input type="number" name="nilai_sisa" class="form-control" min="0" value="{{ $depreciation->nilai_sisa ?? 0 }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Tahun Mulai</label>
                                        <input type="number" name="tahun_mulai" class="form-control" min="1900" max="2100" value="{{ $depreciation->tahun_mulai ?? $asset->tahun_perolehan }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Keterangan</label>
                                        <textarea name="keterangan" class="form-control" rows="2">{{ $depreciation->keterangan ?? '' }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-save"></i> Simpan Konfigurasi
                                    </button>
                                </form>
                            </div>

                            @if(!$depreciation)
                            <div class="alert alert-warning mt-2 mb-0">
                                <i class="fas fa-info-circle me-1"></i> Simpan konfigurasi dulu, lalu tambahkan data penyusutan per tahun.
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Form tambah data per bulan --}}
                    @if($depreciation)
                    <div class="card shadow border-primary">
                        <div class="card-header bg-light py-2">
                            <h6 class="m-0 fw-bold text-primary"><i class="fas fa-plus me-1"></i> Tambah Data Penyusutan</h6>
                        </div>
                        <div class="card-body">
                            @php
                                $lastDep = $depDetails->sortBy(function($d){ return $d->tahun * 100 + $d->bulan; })->last();
                                if ($lastDep) {
                                    $nextBulan = ($lastDep->bulan % 12) + 1;
                                    $nextTahun = $lastDep->bulan == 12 ? $lastDep->tahun + 1 : $lastDep->tahun;
                                } else {
                                    $nextBulan = 1;
                                    $nextTahun = $depreciation->tahun_mulai ?? date('Y');
                                }
                            @endphp
                            <form action="{{ route('depreciations.add-detail', $asset) }}" method="POST">
                                @csrf
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold">Bulan</label>
                                        <select name="bulan" class="form-select" required>
                                            @foreach([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num=>$nama)
                                            <option value="{{ $num }}" {{ $nextBulan==$num?'selected':'' }}>{{ $nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold">Tahun</label>
                                        <input type="number" name="tahun" class="form-control" min="2000" max="2100" value="{{ $nextTahun }}" required>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Nilai Awal Bulan (Rp)</label>
                                    <input type="number" name="nilai_awal" class="form-control" min="0"
                                        value="{{ $lastDep?->nilai_buku ?? $asset->nilai_perolehan }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Beban Penyusutan (Rp)</label>
                                    <input type="number" name="beban_penyusutan" class="form-control" min="0" required placeholder="Isi manual">
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-plus me-1"></i> Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Kolom kanan: tabel + grafik --}}
                <div class="col-md-8">
                    @if($depDetails->count())
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Penyusutan per Bulan</h6>
                            <small class="text-muted">
                                Metode: <strong>{{ $depreciation->metode == 'garis_lurus' ? 'Garis Lurus' : 'Saldo Menurun' }}</strong>
                            </small>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Periode</th>
                                            <th>Nilai Awal</th>
                                            <th>Beban Penyusutan</th>
                                            <th>Akumulasi</th>
                                            <th>Nilai Buku</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $namasBulan = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
                                            $sortedDep = $depDetails->sortBy(function($d){ return $d->tahun * 100 + ($d->bulan ?? 0); });
                                        @endphp
                                        @foreach($sortedDep as $d)
                                        <tr>
                                            <td><strong>{{ isset($namasBulan[$d->bulan]) ? $namasBulan[$d->bulan] : '-' }} {{ $d->tahun }}</strong></td>
                                            <td>Rp {{ number_format($d->nilai_awal, 0, ',', '.') }}</td>
                                            <td class="text-danger">- Rp {{ number_format($d->beban_penyusutan, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($d->akumulasi_penyusutan, 0, ',', '.') }}</td>
                                            <td><strong>Rp {{ number_format($d->nilai_buku, 0, ',', '.') }}</strong></td>
                                            <td>
                                                <form action="{{ route('depreciations.delete-detail', [$asset, $d]) }}" method="POST"
                                                    onsubmit="return confirm('Hapus data {{ isset($namasBulan[$d->bulan])?$namasBulan[$d->bulan]:'' }} {{ $d->tahun }}?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Nilai Buku</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="depreciationChart"></canvas>
                        </div>
                    </div>
                    @else
                    <div class="card shadow">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted">Belum ada data penyusutan. Tambahkan data per bulan di form sebelah kiri.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('costChart');
if (ctx) {
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['BBM', 'Service/Perbaikan', 'Pajak'],
            datasets: [{ data: [{{ $biayaBBM }}, {{ $biayaService }}, {{ $biayaPajak }}], backgroundColor: ['#36b9cc', '#1cc88a', '#e74a3b'] }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
}

@if($depDetails->count())
const depCtx = document.getElementById('depreciationChart');
if (depCtx) {
    new Chart(depCtx, {
        type: 'line',
        data: {
            labels: [{{ $depDetails->sortBy(function($d){ return $d->tahun * 100 + ($d->bulan ?? 0); })->map(function($d){ $b=[1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des']; return '"'.($b[$d->bulan]??'-').' '.$d->tahun.'"'; })->implode(',') }}],
            datasets: [{
                label: 'Nilai Buku (Rp)',
                data: [{{ $depDetails->sortBy(function($d){ return $d->tahun * 100 + ($d->bulan ?? 0); })->pluck('nilai_buku')->implode(',') }}],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78,115,223,0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } }
            }
        }
    });
}
@endif
</script>
@endpush
@endsection