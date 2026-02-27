@extends('layouts.app')

@section('title', 'Daftar Backup')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Backup Database</h1>
        <a href="{{ route('settings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

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

    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">File Backup</h6>
            <form action="{{ route('settings.backup') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i> Buat Backup Baru
                </button>
            </form>
        </div>
        <div class="card-body">
            @if(count($backups) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama File</th>
                            <th>Ukuran</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($backups as $index => $backup)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <i class="fas fa-file-archive text-primary"></i>
                                {{ $backup['name'] }}
                            </td>
                            <td>{{ number_format($backup['size'] / 1024, 2) }} KB</td>
                            <td>{{ $backup['date'] }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('settings.download-backup', $backup['name']) }}" class="btn btn-sm btn-info" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <form action="{{ route('settings.delete-backup', $backup['name']) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus backup ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada backup database</h5>
                <p class="text-muted">Klik tombol "Buat Backup Baru" untuk membuat backup pertama</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Info -->
    <div class="alert alert-info mt-4">
        <i class="fas fa-info-circle"></i>
        <strong>Catatan:</strong> File backup disimpan di folder <code>storage/app/backups/</code>. 
        Pastikan untuk menyimpan backup di lokasi yang aman secara berkala.
    </div>
</div>
@endsection