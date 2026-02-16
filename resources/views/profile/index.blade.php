@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="container-fluid px-4">
    <h1 class="h3 mb-4 text-gray-800">Profil Pengguna</h1>

    <div class="row">
        <!-- Informasi Profil -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <h4>{{ $profile['name'] }}</h4>
                    <p class="text-muted">{{ $profile['role'] }}</p>
                    <hr>
                    <div class="text-start">
                        <p class="mb-2">
                            <i class="fas fa-envelope text-primary"></i>
                            <strong class="ms-2">Email:</strong><br>
                            <span class="ms-4">{{ $profile['email'] }}</span>
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-calendar text-primary"></i>
                            <strong class="ms-2">Bergabung Sejak:</strong><br>
                            <span class="ms-4">{{ date('d F Y', strtotime($profile['joined'])) }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Aktivitas</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="border-start border-primary border-4 ps-3">
                                <h3 class="text-primary">{{ \App\Models\Asset::count() }}</h3>
                                <p class="text-muted mb-0">Total Aset Dikelola</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="border-start border-success border-4 ps-3">
                                <h3 class="text-success">{{ \App\Models\AssetHistory::count() }}</h3>
                                <p class="text-muted mb-0">Total Transfer Aset</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="border-start border-info border-4 ps-3">
                                <h3 class="text-info">Rp {{ number_format(\App\Models\Asset::sum('nilai_perolehan'), 0, ',', '.') }}</h3>
                                <p class="text-muted mb-0">Total Nilai Aset</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="border-start border-warning border-4 ps-3">
                                <h3 class="text-warning">{{ \App\Models\Asset::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count() }}</h3>
                                <p class="text-muted mb-0">Aset Perlu Maintenance</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Info:</strong> Aktivitas terbaru dapat dilihat di <a href="{{ route('dashboard') }}" class="alert-link">halaman Dashboard</a>.
            </div>
        </div>
    </div>
</div>
@endsection