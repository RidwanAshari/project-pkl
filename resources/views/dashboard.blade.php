@extends('layouts.app')

@section('title', 'Dashboard - Manajemen Aset')

@section('content')
@php
    use Carbon\Carbon;

    $assetsByCondition = $assetsByCondition ?? collect();
    $assetsByCategory = $assetsByCategory ?? collect();

    $conditionLabels = $assetsByCondition instanceof \Illuminate\Support\Collection
        ? $assetsByCondition->keys()
        : collect(array_keys((array) $assetsByCondition));

    $conditionValues = $assetsByCondition instanceof \Illuminate\Support\Collection
        ? $assetsByCondition->values()
        : collect(array_values((array) $assetsByCondition));

    $categoryLabels = $assetsByCategory instanceof \Illuminate\Support\Collection
        ? $assetsByCategory->keys()
        : collect(array_keys((array) $assetsByCategory));

    $categoryValues = $assetsByCategory instanceof \Illuminate\Support\Collection
        ? $assetsByCategory->values()
        : collect(array_values((array) $assetsByCategory));
@endphp

<div class="container-fluid px-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Manajemen Aset</h1>
        <div class="text-muted">
            <i class="fas fa-calendar-alt"></i>
            {{ Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">

        <!-- Total Aset -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Total Aset
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">
                            {{ number_format($totalAssets ?? 0) }}
                        </div>
                    </div>
                    <i class="fas fa-boxes fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Total Nilai Aset -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                            Total Nilai Aset
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">
                            Rp {{ number_format($totalValue ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Perlu Maintenance -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                            Perlu Maintenance
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">
                            {{ number_format($needMaintenance ?? 0) }}
                        </div>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Kondisi Baik -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                            Kondisi Baik
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">
                            {{ number_format($assetsByCondition['Baik'] ?? 0) }}
                        </div>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts -->
    <div class="row">

        <!-- Chart Kondisi -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">
                        Aset Berdasarkan Kondisi
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="conditionChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart Kategori -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">
                        Aset Berdasarkan Kategori
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="250"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

const conditionData = {
    labels: {!! json_encode($conditionLabels) !!},
    values: {!! json_encode($conditionValues) !!}
};

if (conditionData.labels.length > 0) {
    new Chart(document.getElementById('conditionChart'), {
        type: 'doughnut',
        data: {
            labels: conditionData.labels,
            datasets: [{
                data: conditionData.values,
                backgroundColor: [
                    '#4e73df','#1cc88a','#f6c23e','#e74a3b','#36b9cc'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}

const categoryData = {
    labels: {!! json_encode($categoryLabels) !!},
    values: {!! json_encode($categoryValues) !!}
};

if (categoryData.labels.length > 0) {
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: categoryData.labels,
            datasets: [{
                label: 'Jumlah Aset',
                data: categoryData.values,
                backgroundColor: '#4e73df'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
}

</script>
@endpush
@endsection