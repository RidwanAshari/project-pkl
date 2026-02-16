@extends('layouts.app')

@section('title', 'Laporan Biaya Kendaraan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Biaya Kendaraan: {{ $asset->nama_aset }}</h1>
        <a href="{{ route('vehicles.show', $asset) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Filter Tahun -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Pilih Tahun</label>
                    <select name="year" class="form-select" onchange="this.form.submit()">
                        @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Biaya Bulanan Tahun {{ $year }}</h6>
        </div>
        <div class="card-body">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <!-- Tabel Detail -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rincian Biaya per Bulan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Bulan</th>
                            <th>BBM</th>
                            <th>Service</th>
                            <th>Perbaikan</th>
                            <th>Penggantian</th>
                            <th>Pajak</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            $totalPerBulan = [];
                            for($i = 1; $i <= 12; $i++) {
                                $totalPerBulan[$i] = [
                                    'bbm' => 0,
                                    'service' => 0,
                                    'perbaikan' => 0,
                                    'penggantian' => 0,
                                    'pajak' => 0
                                ];
                            }
                            
                            foreach($monthlyData as $data) {
                                $bulan = $data->bulan;
                                $jenis = $data->jenis_servis;
                                $total = $data->total;
                                
                                if($jenis == 'Pengisian BBM') $totalPerBulan[$bulan]['bbm'] = $total;
                                elseif($jenis == 'Service Rutin') $totalPerBulan[$bulan]['service'] = $total;
                                elseif($jenis == 'Perbaikan') $totalPerBulan[$bulan]['perbaikan'] = $total;
                                elseif($jenis == 'Penggantian') $totalPerBulan[$bulan]['penggantian'] = $total;
                                elseif($jenis == 'Bayar Pajak') $totalPerBulan[$bulan]['pajak'] = $total;
                            }
                        @endphp
                        
                        @for($i = 1; $i <= 12; $i++)
                        @php
                            $total = array_sum($totalPerBulan[$i]);
                        @endphp
                        <tr>
                            <td><strong>{{ $bulanNames[$i] }}</strong></td>
                            <td>Rp {{ number_format($totalPerBulan[$i]['bbm'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($totalPerBulan[$i]['service'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($totalPerBulan[$i]['perbaikan'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($totalPerBulan[$i]['penggantian'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($totalPerBulan[$i]['pajak'], 0, ',', '.') }}</td>
                            <td class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@php
    $chartData = [];
    for($i = 1; $i <= 12; $i++) {
        $chartData[] = array_sum($totalPerBulan[$i]);
    }
@endphp

const ctx = document.getElementById('monthlyChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
            label: 'Total Biaya (Rp)',
            data: {!! json_encode($chartData) !!},
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            tension: 0.4,
            fill: true
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
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
@endpush
@endsection