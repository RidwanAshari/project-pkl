@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="container-fluid px-4">
    <h1 class="h3 mb-4 text-gray-800">Pengaturan Sistem</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <!-- Tab nav -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab-sistem"><i class="fas fa-server"></i> Sistem</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-master"><i class="fas fa-database"></i> Data Master</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-backup"><i class="fas fa-database"></i> Backup & Restore</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-statistik"><i class="fas fa-chart-bar"></i> Statistik</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Tab Sistem -->
        <div id="tab-sistem" class="tab-pane fade show active">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex align-items-center gap-2">
                            <i class="fas fa-info-circle text-primary"></i>
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Aplikasi</h6>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Nama Aplikasi</span>
                                    <strong>{{ $info['app_name'] }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Environment</span>
                                    <span class="badge {{ $info['app_env'] == 'production' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ strtoupper($info['app_env']) }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">PHP Version</span>
                                    <strong>{{ $info['php_version'] }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Laravel Version</span>
                                    <strong>{{ $info['laravel_version'] }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Database</span>
                                    <strong>{{ $info['database'] }}</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex align-items-center gap-2">
                            <i class="fas fa-bolt text-warning"></i>
                            <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-3">
                                <a href="{{ route('settings.pemegang') }}" class="btn btn-primary d-flex align-items-center gap-2">
                                    <i class="fas fa-users-gear fa-fw"></i>
                                    <div class="text-start">
                                        <div class="fw-semibold">Kelola Pemegang Aset</div>
                                        <small class="opacity-75">Tambah, edit, hapus pemegang aset</small>
                                    </div>
                                </a>
                                <a href="{{ route('settings.bengkel') }}" class="btn btn-primary d-flex align-items-center gap-2">
                                    <i class="fas fa-wrench fa-fw"></i>
                                    <div class="text-start">
                                        <div class="fw-semibold">Kelola Bengkel</div>
                                        <small class="opacity-75">Daftar bengkel mitra</small>
                                    </div>
                                </a>

                                <form action="{{ route('settings.clear-cache') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning w-100 d-flex align-items-center gap-2" onclick="return confirm('Clear cache sekarang?')">
                                        <i class="fas fa-broom fa-fw"></i>
                                        <div class="text-start">
                                            <div class="fw-semibold">Clear Cache</div>
                                            <small class="opacity-75">Bersihkan cache aplikasi</small>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Data Master -->
        <div id="tab-master" class="tab-pane fade">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users"></i> Manajemen Pengguna</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Kelola pengguna sistem dan hak akses mereka.</p>
                            <a href="{{ route('settings.pemegang') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-right"></i> Kelola Pengguna
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-wrench"></i> Data Bengkel</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Kelola daftar bengkel rekanan untuk servis kendaraan.</p>
                            <a href="{{ route('settings.bengkel') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-right"></i> Kelola Bengkel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Backup -->
        <div id="tab-backup" class="tab-pane fade">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-database"></i> Backup Database</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Buat salinan cadangan database sistem untuk keamanan data.</p>
                            <form action="{{ route('settings.backup') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Backup database sekarang?')">
                                    <i class="fas fa-download"></i> Backup Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-folder-open"></i> Daftar Backup</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Lihat dan kelola file backup yang sudah dibuat sebelumnya.</p>
                            <a href="{{ route('settings.backups') }}" class="btn btn-outline-info">
                                <i class="fas fa-list"></i> Lihat Daftar Backup
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Statistik -->
        <div id="tab-statistik" class="tab-pane fade">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Penggunaan Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-4">
                            <div class="border rounded p-3">
                                <i class="fas fa-boxes fa-2x text-primary mb-2"></i>
                                <h3 class="fw-bold text-primary">{{ $stats['total_aset'] }}</h3>
                                <small class="text-muted">Total Aset</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="border rounded p-3">
                                <i class="fas fa-exchange-alt fa-2x text-success mb-2"></i>
                                <h3 class="fw-bold text-success">{{ $stats['total_transfer'] }}</h3>
                                <small class="text-muted">Total Transfer</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="border rounded p-3">
                                <i class="fas fa-image fa-2x text-info mb-2"></i>
                                <h3 class="fw-bold text-info">{{ $stats['total_foto'] }}</h3>
                                <small class="text-muted">File Foto</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="border rounded p-3">
                                <i class="fas fa-qrcode fa-2x text-warning mb-2"></i>
                                <h3 class="fw-bold text-warning">{{ $stats['total_qr'] }}</h3>
                                <small class="text-muted">QR Codes</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
