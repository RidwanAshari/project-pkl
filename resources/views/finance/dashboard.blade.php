@extends('layouts.app')

@section('title', 'Dashboard Finance - DPB')

@section('content')
<div class="container-fluid px-4">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Finance</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Tagihan masuk --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center">
            @if($readyForDpb->count())
            <span class="badge bg-danger me-2 fs-6">{{ $readyForDpb->count() }}</span>
            @endif
            <h6 class="m-0 font-weight-bold text-primary">Tagihan Masuk - Perlu Dibuatkan DPB</h6>
        </div>
        <div class="card-body">
            @if($readyForDpb->isEmpty())
            <div class="text-center py-4 text-muted">
                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                Belum ada tagihan masuk yang perlu diproses.
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal Servis</th>
                            <th>Kendaraan</th>
                            <th>Jenis Servis</th>
                            <th>Bengkel</th>
                            <th>Biaya Aktual</th>
                            <th>Nota Bengkel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($readyForDpb as $m)
                        <tr>
                            <td>{{ $m->tanggal->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $m->asset->nama_aset }}</strong><br>
                                <small class="text-muted">{{ $m->asset->kode_aset ?? '-' }}</small>
                            </td>
                            <td><span class="badge bg-primary">{{ $m->jenis_servis }}</span></td>
                            <td>{{ $m->bengkel ?? '-' }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format($m->biaya_aktual, 0, ',', '.') }}</td>
                            <td>
                                @if($m->file_nota_bengkel)
                                <a href="{{ asset('storage/' . $m->file_nota_bengkel) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-receipt"></i> Lihat Nota
                                </a>
                                @endif
                            </td>
                            <td>
                                {{-- Arahkan ke form DPB manual, bukan langsung POST --}}
                                <a href="{{ route('finance.form-dpb', $m) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-file-invoice"></i> Buat DPB
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    {{-- Daftar DPB --}}
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Surat DPB</h6>
        </div>
        <div class="card-body">
            @if($dpbList->isEmpty())
            <p class="text-muted text-center py-3">Belum ada DPB yang dibuat.</p>
            @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nomor DPB</th>
                            <th>Tanggal</th>
                            <th>Kendaraan</th>
                            <th>Total Biaya</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dpbList as $dpb)
                        <tr>
                            <td><strong>{{ $dpb->nomor_dpb }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($dpb->tanggal_dpb)->format('d/m/Y') }}</td>
                            <td>{{ optional($dpb->maintenance?->asset)->nama_aset ?? '-' }}</td>
                            <td class="fw-bold">Rp {{ number_format($dpb->total_biaya, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $dpb->status == 'final' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($dpb->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('finance.download-dpb', $dpb) }}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fas fa-print"></i> Cetak DPB
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $dpbList->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection