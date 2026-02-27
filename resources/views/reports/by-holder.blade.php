@extends('layouts.app')

@section('title', 'Laporan Per Pemegang')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Aset Per Pemegang</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($data->count() > 0)
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pemegang Aset</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pemegang</th>
                            <th>Jumlah Aset</th>
                            <th>Total Nilai Aset</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <i class="fas fa-user-circle text-primary"></i>
                                <strong>{{ $item->pemegang_saat_ini }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $item->jumlah }} unit</span>
                            </td>
                            <td class="text-success fw-bold">
                                Rp {{ number_format($item->total_nilai, 0, ',', '.') }}
                            </td>
                            <td>
                                <a href="{{ route('assets.index', ['search' => $item->pemegang_saat_ini]) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <td colspan="2"><strong>TOTAL</strong></td>
                            <td><strong>{{ $data->sum('jumlah') }} unit</strong></td>
                            <td class="text-success fw-bold">
                                <strong>Rp {{ number_format($data->sum('total_nilai'), 0, ',', '.') }}</strong>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart Distribusi -->
    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Distribusi Aset Per Pemegang</h6>
        </div>
        <div class="card-body">
            <canvas id="holderChart"></canvas>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('holderChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data->pluck('pemegang_saat_ini')) !!},
                datasets: [{
                    label: 'Jumlah Aset',
                    data: {!! json_encode($data->pluck('jumlah')) !!},
                    backgroundColor: '#4e73df',
                    borderColor: '#4e73df',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
    @endpush

    @else
    <div class="card shadow">
        <div class="card-body text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada aset yang memiliki pemegang</h5>
            <p class="text-muted">Tambahkan pemegang aset melalui menu Data Aset</p>
            <a href="{{ route('assets.index') }}" class="btn btn-primary mt-3">
                <i class="fas fa-boxes"></i> Ke Data Aset
            </a>
        </div>
    </div>
    @endif
</div>
@endsection