@extends('layouts.app')

@section('title', 'Data Aset')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Aset</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('assets-pinjaman.export-excel') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('assets-pinjaman.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Aset
            </a>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter & Search -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('assets.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="Bangunan" {{ request('kategori') == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                        <option value="Tanah" {{ request('kategori') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                        <option value="Kendaraan" {{ request('kategori') == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                        <option value="Peralatan" {{ request('kategori') == 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                        <option value="Investasi" {{ request('kategori') == 'Investasi' ? 'selected' : '' }}>Investasi</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-select">
                        <option value="">Semua Kondisi</option>
                        <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Kode, nama, atau pemegang..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Aset -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Kategori</th>
                            <th>Kondisi</th>
                            <th>Pemegang</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                        <tr>
                            <td><strong>{{ $asset->kode_aset }}</strong></td>
                            <td>{{ $asset->nama_aset }}</td>
                            <td>
                                <span class="badge bg-info">{{ $asset->kategori }}</span>
                            </td>
                            <td>
                                @if($asset->kondisi == 'Baik')
                                    <span class="badge bg-success">{{ $asset->kondisi }}</span>
                                @elseif($asset->kondisi == 'Rusak Ringan')
                                    <span class="badge bg-warning">{{ $asset->kondisi }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $asset->kondisi }}</span>
                                @endif
                            </td>
                            <td>{{ $asset->pemegang_saat_ini ?? '-' }}</td>
                            <td>Rp {{ number_format($asset->nilai_perolehan, 0, ',', '.') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('assets.show', $asset) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('assets.edit', $asset) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus aset ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                Belum ada data aset
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $assets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection