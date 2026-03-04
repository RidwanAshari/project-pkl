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

    {{-- ===== NOTIFIKASI STNK ===== --}}
    @if($stnkAlerts->count() > 0)
    <div class="card shadow mb-4 border-0">
        <div class="card-header py-2 d-flex justify-content-between align-items-center"
             style="background: linear-gradient(90deg,#dc3545,#fd7e14); color:white;">
            <span class="fw-bold">
                <i class="fas fa-bell me-2"></i>
                Peringatan STNK — {{ $stnkAlerts->count() }} kendaraan perlu diperhatikan
            </span>
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('dashboard.set-threshold') }}" method="POST" class="d-flex align-items-center gap-2 mb-0">
                    @csrf
                    <label class="text-white mb-0 small">Ingatkan:</label>
                    <select name="threshold" class="form-select form-select-sm" style="width:auto;"
                        onchange="this.form.submit()">
                        @foreach([30,60,90,120,180] as $opt)
                        <option value="{{ $opt }}" {{ $threshold == $opt ? 'selected' : '' }}>{{ $opt }} hari</option>
                        @endforeach
                    </select>
                    <label class="text-white mb-0 small">sebelum expired</label>
                </form>
                <button class="btn btn-sm btn-light" data-bs-toggle="collapse" data-bs-target="#stnkDetail">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>
        <div id="stnkDetail" class="collapse show">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kendaraan</th>
                                <th>Nomor Plat</th>
                                <th>Tanggal Berlaku STNK</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stnkAlerts as $alert)
                            <tr class="{{ $alert->status === 'expired' ? 'table-danger' : ($alert->status === 'kritis' ? 'table-warning' : 'table-info bg-opacity-25') }}">
                                <td><strong>{{ $alert->asset->nama_aset ?? '-' }}</strong></td>
                                <td><span class="badge bg-dark">{{ $alert->nomor_plat }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($alert->tanggal_berlaku)->format('d/m/Y') }}</td>
                                <td>
                                    @if($alert->status === 'expired')
                                        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>EXPIRED {{ abs($alert->hari_sisa) }} hari lalu</span>
                                    @elseif($alert->status === 'kritis')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i>{{ $alert->hari_sisa }} hari lagi</span>
                                    @else
                                        <span class="badge bg-info text-dark"><i class="fas fa-clock me-1"></i>{{ $alert->hari_sisa }} hari lagi</span>
                                    @endif
                                </td>
                                <td>
                                    @if($alert->asset)
                                    <a href="{{ route('vehicles.show', $alert->asset) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- ===== END NOTIFIKASI STNK ===== --}}

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
                <div class="card-body"><canvas id="conditionChart"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aset Berdasarkan Kategori</h6>
                </div>
                <div class="card-body"><canvas id="categoryChart"></canvas></div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i>Aktivitas Terbaru
                    </h6>
                    <a href="{{ route('profile.index') }}" class="btn btn-sm btn-outline-primary">Lihat Profil</a>
                </div>
                <div class="card-body p-0">
                    @if($recentActivities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Aset</th><th>Dari</th><th>Ke</th><th>Nomor BA</th><th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentActivities as $activity)
                                <tr>
                                    <td>
                                        <i class="fas fa-exchange-alt text-primary me-2"></i>
                                        <strong>{{ $activity->asset->nama_aset ?? '-' }}</strong>
                                        <br><small class="text-muted">{{ $activity->asset->kode_aset ?? '' }}</small>
                                    </td>
                                    <td>{{ $activity->dari_pemegang ?? '-' }}</td>
                                    <td>{{ $activity->ke_pemegang }}</td>
                                    <td><span class="badge bg-secondary">{{ $activity->nomor_ba }}</span></td>
                                    <td><small class="text-muted"><i class="fas fa-clock me-1"></i>{{ $activity->created_at->diffForHumans() }}</small></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>Belum ada aktivitas transfer aset
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Charts
new Chart(document.getElementById('conditionChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($assetsByCondition->keys()) !!},
        datasets: [{ data: {!! json_encode($assetsByCondition->values()) !!}, backgroundColor: ['#4e73df','#1cc88a','#f6c23e','#e74a3b','#36b9cc'], borderWidth: 2 }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
new Chart(document.getElementById('categoryChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($assetsByCategory->keys()) !!},
        datasets: [{ label: 'Jumlah Aset', data: {!! json_encode($assetsByCategory->values()) !!}, backgroundColor: '#4e73df' }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }, plugins: { legend: { display: false } } }
});

// ===== BROWSER PUSH NOTIFICATION =====
@php
$_stnkJson = $stnkAlerts->map(function($v) {
    return [
        'nama'      => $v->asset->nama_aset ?? '-',
        'nopol'     => $v->nomor_plat,
        'sisa_hari' => $v->sisa_hari,
        'tgl'       => $v->tgl_berlaku->format('d/m/Y'),
        'expired'   => $v->sisa_hari < 0,
    ];
})->values();
@endphp
const stnkData = {!! json_encode($_stnkJson) !!};

function kirimBrowserNotif(item) {
    let title, body;
    if (item.expired) {
        title = '🚨 STNK EXPIRED!';
        body  = `${item.nama} (${item.nopol}) - STNK sudah expired ${Math.abs(item.sisa_hari)} hari lalu!`;
    } else if (item.sisa_hari <= 7) {
        title = '⚠️ STNK Hampir Habis!';
        body  = `${item.nama} (${item.nopol}) - STNK habis ${item.sisa_hari} hari lagi! (${item.tgl})`;
    } else {
        title = '🔔 Pengingat STNK';
        body  = `${item.nama} (${item.nopol}) - STNK habis ${item.sisa_hari} hari lagi (${item.tgl})`;
    }
    new Notification(title, { body, icon: '/favicon.ico' });
}

function kirimSemuaNotif() {
    if (!stnkData || !stnkData.length) return;
    stnkData.forEach(item => kirimBrowserNotif(item));
}

if ('Notification' in window && stnkData.length > 0) {
    if (Notification.permission === 'granted') {
        setTimeout(kirimSemuaNotif, 1000);
    } else if (Notification.permission === 'default') {
        setTimeout(() => {
            Notification.requestPermission().then(perm => {
                if (perm === 'granted') kirimSemuaNotif();
            });
        }, 2000);
    }
    setInterval(() => {
        if (Notification.permission === 'granted') kirimSemuaNotif();
    }, 1800000);
}
</script>
@endpush