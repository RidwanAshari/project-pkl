@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-header', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistic Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Total Aset
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalAssets }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                            Total Nilai Aset
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">
                            Rp {{ number_format($totalValue, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                            Aset Baik
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 fw-bold text-gray-800">
                                    {{ $assetsByCondition->where('kondisi', 'Baik')->first()->total ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                            Perlu Perawatan
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">
                            {{ $assetsByCondition->whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->sum('total') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Assets -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Aset Terbaru</h6>
                <a href="{{ route('assets.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Aset
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode Aset</th>
                                <th>Nama Aset</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Pemegang</th>
                                <th>Kondisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAssets as $asset)
                            <tr>
                                <td><strong>{{ $asset->kode_aset }}</strong></td>
                                <td>{{ $asset->nama_aset }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $asset->kategori }}</span>
                                </td>
                                <td>{{ $asset->lokasi }}</td>
                                <td>{{ $asset->pemegang_saat_ini ?? '-' }}</td>
                                <td>
                                    @php
                                        $conditionColors = [
                                            'Baik' => 'success',
                                            'Rusak Ringan' => 'warning',
                                            'Rusak Berat' => 'danger',
                                            'Hilang' => 'dark',
                                            'Dijual' => 'info',
                                            'Dihapuskan' => 'secondary'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $conditionColors[$asset->kondisi] ?? 'secondary' }}">
                                        {{ $asset->kondisi }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('assets.show', $asset) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data aset</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('assets.index') }}" class="btn btn-link">
                    Lihat Semua Aset <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 fw-bold">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('assets.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah Aset Baru
                    </a>
                    <a href="{{ route('reports.index') }}" class="btn btn-success">
                        <i class="fas fa-chart-bar me-2"></i> Lihat Laporan
                    </a>
                    <a href="{{ route('assets.index') }}" class="btn btn-info">
                        <i class="fas fa-search me-2"></i> Cari Aset
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 fw-bold">Kondisi Aset</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="conditionChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk chart
    const conditionData = @json($assetsByCondition);
    
    // Prepare chart data
    const labels = conditionData.map(item => item.kondisi);
    const data = conditionData.map(item => item.total);
    const colors = ['#1cc88a', '#f6c23e', '#e74a3b', '#858796', '#36b9cc', '#6f42c1'];
    
    // Create chart
    const ctx = document.getElementById('conditionChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Aset',
                data: data,
                backgroundColor: colors,
                borderColor: colors.map(color => color.replace('0.8', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection