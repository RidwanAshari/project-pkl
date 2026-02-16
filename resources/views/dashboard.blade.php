@extends('layouts.app')

@section('title', 'Dashboard - Manajemen Aset')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Manajemen Aset</h1>
        <div class="text-muted">
            <i class="fas fa-calendar-alt"></i> {{ date('d F Y') }}
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Aset</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalAssets) }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-boxes fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Nilai Aset</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Perlu Maintenance</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($needMaintenance) }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Kondisi Baik</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($assetsByCondition['Baik'] ?? 0) }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aset Berdasarkan Kondisi</h6>
                </div>
                <div class="card-body">
                    <canvas id="conditionChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aset Berdasarkan Kategori</h6>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru (dipindah dari Profil) -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i>Aktivitas Terbaru
                    </h6>
                    <a href="{{ route('profile.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Profil
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($recentActivities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Aset</th>
                                    <th>Dari</th>
                                    <th>Ke</th>
                                    <th>Nomor BA</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentActivities as $activity)
                                <tr>
                                    <td>
                                        <i class="fas fa-exchange-alt text-primary me-2"></i>
                                        <strong>{{ $activity->asset->nama_aset ?? '-' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $activity->asset->kode_aset ?? '' }}</small>
                                    </td>
                                    <td>{{ $activity->dari_pemegang ?? '-' }}</td>
                                    <td>{{ $activity->ke_pemegang }}</td>
                                    <td><span class="badge bg-secondary">{{ $activity->nomor_ba }}</span></td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>{{ $activity->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Belum ada aktivitas transfer aset
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
const conditionCtx = document.getElementById('conditionChart').getContext('2d');
new Chart(conditionCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($assetsByCondition->keys()) !!},
        datasets: [{
            data: {!! json_encode($assetsByCondition->values()) !!},
            backgroundColor: ['#4e73df','#1cc88a','#f6c23e','#e74a3b','#36b9cc'],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($assetsByCategory->keys()) !!},
        datasets: [{
            label: 'Jumlah Aset',
            data: {!! json_encode($assetsByCategory->values()) !!},
            backgroundColor: '#4e73df',
            borderColor: '#4e73df',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush
@endsection