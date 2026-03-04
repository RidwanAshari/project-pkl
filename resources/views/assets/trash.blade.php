@extends('layouts.app')
@section('title', 'Aset Dihapus')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-trash-restore me-2 text-danger"></i>Aset Dihapus</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Filter tipe --}}
    <div class="card shadow mb-3">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label mb-1">Tipe Dashboard</label>
                    <select name="tipe" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        <option value="aset" {{ request('tipe')=='aset'?'selected':'' }}>Data Aset</option>
                        <option value="biaya" {{ request('tipe')=='biaya'?'selected':'' }}>Aset Biaya</option>
                        <option value="pinjaman" {{ request('tipe')=='pinjaman'?'selected':'' }}>Aset Pinjaman</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1">Kategori</label>
                    <select name="kategori" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        @foreach(['Bangunan','Tanah','Kendaraan','Peralatan','Inventaris Barang dan Perabot Kantor'] as $k)
                        <option value="{{ $k }}" {{ request('kategori')==$k?'selected':'' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1">Cari</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Nama atau kode..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search me-1"></i>Filter</button>
                    <a href="{{ route('assets.trash') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Kategori</th>
                            <th>Tipe</th>
                            <th>Pemegang Terakhir</th>
                            <th>Nilai</th>
                            <th>Dihapus Oleh</th>
                            <th>Alasan</th>
                            <th>Tanggal Hapus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                        <tr>
                            <td><strong class="text-muted">{{ $asset->kode_aset }}</strong></td>
                            <td>{{ $asset->nama_aset }}</td>
                            <td><span class="badge bg-secondary">{{ $asset->kategori }}</span></td>
                            <td>
                                @php $tipe = $asset->tipe_dashboard; @endphp
                                <span class="badge {{ $tipe=='biaya'?'bg-info':($tipe=='pinjaman'?'bg-warning text-dark':'bg-primary') }}">
                                    {{ ucfirst($tipe) }}
                                </span>
                            </td>
                            <td>{{ $asset->pemegang_saat_ini ?? '-' }}</td>
                            <td>Rp {{ number_format($asset->nilai_perolehan,0,',','.') }}</td>
                            <td>{{ $asset->dihapus_oleh ?? '-' }}</td>
                            <td><small class="text-muted">{{ $asset->alasan_hapus ?? '-' }}</small></td>
                            <td><small>{{ $asset->deleted_at->format('d/m/Y H:i') }}</small></td>
                            <td>
                                <div class="d-flex gap-1">
                                    {{-- Restore --}}
                                    <form action="{{ route('assets.restore', $asset->id) }}" method="POST" onsubmit="return confirm('Pulihkan aset ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Pulihkan">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </form>
                                    {{-- Hapus Permanen --}}
                                    <form action="{{ route('assets.force-delete', $asset->id) }}" method="POST" onsubmit="return confirm('HAPUS PERMANEN? Data tidak bisa dikembalikan!')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-5">
                                <i class="fas fa-check-circle fa-3x mb-3 d-block text-success"></i>
                                Tidak ada aset yang dihapus
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($assets->hasPages())
        <div class="card-footer">{{ $assets->links() }}</div>
        @endif
    </div>
</div>
@endsection