@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kendaraan: {{ $asset->nama_aset }}</h1>
        <div>
            <a href="{{ route('vehicles.report-cost', $asset) }}" class="btn btn-info">
                <i class="fas fa-chart-line"></i> Laporan Biaya
            </a>
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
                                <tr>
                                    <td width="40%"><strong>Nama Pemilik/Pengguna</strong></td>
                                    <td>{{ $vehicleDetail->nama_pemilik ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jabatan</strong></td>
                                    <td>{{ $vehicleDetail->jabatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td>{{ $vehicleDetail->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor Plat</strong></td>
                                    <td><span class="badge bg-dark">{{ $vehicleDetail->nomor_plat ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Merk</strong></td>
                                    <td>{{ $asset->merk ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Type</strong></td>
                                    <td>{{ $asset->tipe ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Model</strong></td>
                                    <td>{{ $vehicleDetail->model ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Pembuatan</strong></td>
                                    <td>{{ $vehicleDetail->tahun_pembuatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Isi Silinder</strong></td>
                                    <td>{{ $vehicleDetail->isi_silinder ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor Rangka</strong></td>
                                    <td>{{ $vehicleDetail->nomor_rangka ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor Mesin</strong></td>
                                    <td>{{ $vehicleDetail->nomor_mesin ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Warna</strong></td>
                                    <td>{{ $vehicleDetail->warna ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Bahan Bakar</strong></td>
                                    <td>{{ $vehicleDetail->bahan_bakar ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Warna TNKB</strong></td>
                                    <td>{{ $vehicleDetail->warna_tnkb ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Registrasi</strong></td>
                                    <td>{{ $vehicleDetail->tahun_registrasi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor BPKB</strong></td>
                                    <td>{{ $vehicleDetail->nomor_bpkb ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Berlaku</strong></td>
                                    <td>{{ $vehicleDetail->tanggal_berlaku ? $vehicleDetail->tanggal_berlaku->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Berat (KG)</strong></td>
                                    <td>{{ $vehicleDetail->berat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Sumbu</strong></td>
                                    <td>{{ $vehicleDetail->sumbu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Penumpang</strong></td>
                                    <td>{{ $vehicleDetail->penumpang ?? '-' }}</td>
                                </tr>
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
                    <a href="{{ route('vehicles.create-maintenance', $asset) }}" class="btn btn-sm btn-success">
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($maintenances as $m)
                                <tr>
                                    <td>{{ $m->tanggal->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($m->jenis_servis == 'Pengisian BBM') bg-info
                                            @elseif($m->jenis_servis == 'Service Rutin') bg-success
                                            @elseif($m->jenis_servis == 'Perbaikan') bg-warning
                                            @elseif($m->jenis_servis == 'Penggantian') bg-primary
                                            @else bg-danger
                                            @endif">
                                            {{ $m->jenis_servis }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($m->jenis_servis == 'Pengisian BBM')
                                            {{ $m->jenis_bbm }} - {{ $m->jumlah_liter }}L @ Rp{{ number_format($m->harga_per_liter, 0, ',', '.') }}
                                            <br><small class="text-muted">Odometer: {{ $m->odometer }} km</small>
                                        @else
                                            {{ $m->keterangan ?? '-' }}
                                            @if($m->bengkel)
                                                <br><small class="text-muted">{{ $m->bengkel }}</small>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="fw-bold">Rp {{ number_format($m->biaya, 0, ',', '.') }}</td>
                                    <td>
                                        @if($m->file_nota)
                                        <a href="{{ asset('storage/' . $m->file_nota) }}" target="_blank" class="btn btn-sm btn-info" title="Lihat Nota">
                                            <i class="fas fa-file"></i>
                                        </a>
                                        @endif
                                        @if($m->file_surat_pengantar)
                                        <a href="{{ route('vehicles.download-surat', [$asset, $m]) }}" class="btn btn-sm btn-success" title="Download Surat Pengantar">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        @endif
                                        <form action="{{ route('vehicles.delete-maintenance', [$asset, $m]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada data pemeliharaan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $maintenances->links() }}
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
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($totalBBM, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-left-success">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Biaya Service</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($totalService, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-left-danger">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Biaya Pajak</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($totalPajak, 0, ',', '.') }}</div>
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
            datasets: [{
                data: [{{ $totalBBM }}, {{ $totalService }}, {{ $totalPajak }}],
                backgroundColor: ['#36b9cc', '#1cc88a', '#e74a3b']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}
</script>
@endpush
@endsection