@extends('layouts.app')

@section('title', 'Verifikasi Surat - Kabag')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Verifikasi Maintenance</h1>
        <div class="text-muted">
            <i class="fas fa-file-signature"></i> ACC / Tolak / Review
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Aset</th>
                            <th>Jenis Servis</th>
                            <th>Tanggal</th>
                            <th>Biaya</th>
                            <th>Status</th>
                            <th style="width: 360px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($maintenances as $m)
                            <tr>
                                <td>{{ $m->id }}</td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $m->asset->nama_aset ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $m->asset->kode_aset ?? '-' }}
                                    </div>
                                </td>

                                <td>{{ $m->jenis_servis }}</td>

                                <td>
                                    {{ $m->tanggal 
                                        ? \Carbon\Carbon::parse($m->tanggal)->format('d-m-Y') 
                                        : '-' }}
                                </td>

                                <td>
                                    Rp {{ number_format($m->biaya, 0, ',', '.') }}
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @if($m->status_surat == 'pending')
                                        <span class="badge bg-secondary">Menunggu</span>
                                    @elseif($m->status_surat == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($m->status_surat == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">

                                        {{-- REVIEW --}}
                                        @if($m->file_surat_pengantar)
                                            <a target="_blank"
                                               href="{{ route('kabag.surat.review', $m->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Review
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">
                                                Tanpa Surat
                                            </span>
                                        @endif

                                        {{-- ACC / TOLAK hanya jika pending --}}
                                        @if($m->status_surat == 'pending')
                                            <form action="{{ route('kabag.acc.store', $m->id) }}" 
                                                  method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm btn-success"
                                                        onclick="return confirm('ACC data ini?')">
                                                    <i class="fas fa-check"></i> ACC
                                                </button>
                                            </form>

                                            <form action="{{ route('kabag.acc.reject', $m->id) }}" 
                                                  method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Tolak data ini?')">
                                                    <i class="fas fa-xmark"></i> Tolak
                                                </button>
                                            </form>
                                        @endif

                                        {{-- DOWNLOAD hanya jika approved --}}
                                        @if($m->status_surat == 'approved' && $m->file_surat_pengantar)
                                            <a target="_blank"
                                               href="{{ route('vehicles.download-surat', [$m->asset_id, $m->id]) }}"
                                               class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Tidak ada data maintenance.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $maintenances->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
