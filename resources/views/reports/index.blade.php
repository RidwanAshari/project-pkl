@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Aset</h1>
        <a href="{{ route('reports.export-pdf') }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export PDF Lengkap
        </a>
    </div>

    <div class="row">
        <!-- Laporan Per Kategori -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-boxes fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Laporan Per Kategori</h5>
                    <p class="text-muted">Lihat daftar aset berdasarkan kategori</p>
                    <a href="{{ route('reports.by-category') }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Laporan Per Kondisi -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Laporan Per Kondisi</h5>
                    <p class="text-muted">Lihat daftar aset berdasarkan kondisi</p>
                    <a href="{{ route('reports.by-condition') }}" class="btn btn-success">
                        <i class="fas fa-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Laporan Per Pemegang -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Laporan Per Pemegang</h5>
                    <p class="text-muted">Lihat daftar aset per pemegang</p>
                    <a href="{{ route('reports.by-holder') }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Statistik Aset</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border-end">
                                <h2 class="text-primary">{{ \App\Models\Asset::count() }}</h2>
                                <p class="text-muted mb-0">Total Aset</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-end">
                                <h2 class="text-success">Rp {{ number_format(\App\Models\Asset::sum('nilai_perolehan'), 0, ',', '.') }}</h2>
                                <p class="text-muted mb-0">Total Nilai Aset</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-end">
                                <h2 class="text-info">{{ \App\Models\Asset::where('kondisi', 'Baik')->count() }}</h2>
                                <p class="text-muted mb-0">Kondisi Baik</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h2 class="text-warning">{{ \App\Models\Asset::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count() }}</h2>
                            <p class="text-muted mb-0">Perlu Maintenance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection