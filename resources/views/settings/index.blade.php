@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="container-fluid px-4">
    <h1 class="h3 mb-4 text-gray-800">Pengaturan Sistem</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Informasi Sistem -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Sistem</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%"><strong>Nama Aplikasi</strong></td>
                            <td>{{ $info['app_name'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Environment</strong></td>
                            <td>
                                <span class="badge {{ $info['app_env'] == 'production' ? 'bg-success' : 'bg-warning' }}">
                                    {{ strtoupper($info['app_env']) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>PHP Version</strong></td>
                            <td>{{ $info['php_version'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Laravel Version</strong></td>
                            <td>{{ $info['laravel_version'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Database</strong></td>
                            <td>{{ $info['database'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('settings.pemegang') }}" class="btn btn-primary">
                            <i class="fas fa-users"></i> Kelola Pemegang Aset
                        </a>

                        <a href="{{ route('settings.bengkel') }}" class="btn btn-primary">
                            <i class="fas fa-wrench"></i> Kelola Bengkel
                        </a>

                        <form action="{{ route('settings.backup') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Backup database sekarang?')">
                                <i class="fas fa-database"></i> Backup Database
                            </button>
                        </form>

                        <a href="{{ route('settings.backups') }}" class="btn btn-info">
                            <i class="fas fa-folder-open"></i> Lihat Daftar Backup
                        </a>

                        <form action="{{ route('settings.clear-cache') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Hapus semua cache?')">
                                <i class="fas fa-broom"></i> Clear Cache
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Penggunaan -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Penggunaan</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-boxes fa-2x text-primary mb-2"></i>
                            <h4>{{ \App\Models\Asset::count() }}</h4>
                            <p class="text-muted mb-0">Total Aset</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-exchange-alt fa-2x text-success mb-2"></i>
                            <h4>{{ \App\Models\AssetHistory::count() }}</h4>
                            <p class="text-muted mb-0">Total Transfer</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-folder fa-2x text-info mb-2"></i>
                            <h4>{{ count(array_diff(scandir(storage_path('app/public/assets')), ['.', '..'])) }}</h4>
                            <p class="text-muted mb-0">File Foto</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-qrcode fa-2x text-warning mb-2"></i>
                            <h4>{{ count(array_diff(scandir(storage_path('app/public/qrcodes')), ['.', '..'])) }}</h4>
                            <p class="text-muted mb-0">QR Codes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow border-left-info">
                <div class="card-body">
                    <h6 class="text-info"><i class="fas fa-lightbulb"></i> Tips Penggunaan</h6>
                    <ul class="mb-0">
                        <li>Lakukan backup database secara berkala untuk menjaga keamanan data</li>
                        <li>Clear cache jika mengalami masalah setelah update sistem</li>
                        <li>Periksa log error di storage/logs untuk troubleshooting</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection