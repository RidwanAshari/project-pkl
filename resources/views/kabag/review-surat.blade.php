@extends('layouts.app')

@section('title', 'Review Surat Pengantar')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Review Surat Pengantar</h1>
        <a href="{{ route('kabag.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- Info Permintaan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Permintaan Servis</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><td width="40%"><strong>Tanggal</strong></td><td>{{ $maintenance->tanggal->format('d/m/Y') }}</td></tr>
                        <tr><td><strong>Kendaraan</strong></td><td>{{ $maintenance->asset->nama_aset }}</td></tr>
                        <tr><td><strong>Kode Aset</strong></td><td>{{ $maintenance->asset->kode_aset }}</td></tr>
                        <tr><td><strong>Nomor Plat</strong></td><td>{{ $maintenance->asset->vehicleDetail?->nomor_plat ?? '-' }}</td></tr>
                        <tr><td><strong>Jenis Servis</strong></td><td><span class="badge bg-primary">{{ $maintenance->jenis_servis }}</span></td></tr>
                        <tr><td><strong>Bengkel Tujuan</strong></td><td>{{ $maintenance->bengkel ?? '-' }}</td></tr>
                        <tr><td><strong>Keterangan</strong></td><td>{{ $maintenance->keterangan ?? '-' }}</td></tr>
                    </table>

                    <!-- Preview surat pengantar -->
                    <div class="mt-3">
                        <a href="{{ route('vehicles.maintenance.surat-pengantar', [$maintenance->asset, $maintenance]) }}" 
                           target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-file-pdf"></i> Preview Surat Pengantar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @php $jabatan = auth()->user()->position ?? ''; $isEko = str_contains($jabatan, 'Ka Sub Bag'); @endphp

            {{-- STATUS BADGE --}}
            <div class="alert alert-{{ $maintenance->status_surat === 'disetujui' ? 'success' : ($maintenance->status_surat === 'menunggu_eko' ? 'info' : 'warning') }} mb-3">
                <strong>Status:</strong>
                @if($maintenance->status_surat === 'menunggu_acc') <i class="fas fa-clock me-1"></i> Menunggu Persetujuan Kabag
                @elseif($maintenance->status_surat === 'menunggu_eko') <i class="fas fa-user-check me-1"></i> Menunggu Verifikasi Ka.Sub.bag.
                    @if($maintenance->approved_by) <br><small>Kabag: <strong>{{ $maintenance->approved_by }}</strong> ({{ $maintenance->approved_at?->format('d/m/Y H:i') }})</small> @endif
                @elseif($maintenance->status_surat === 'disetujui') <i class="fas fa-check-double me-1"></i> Selesai Diverifikasi
                    @if($maintenance->approved_by) <br><small>Kabag: <strong>{{ $maintenance->approved_by }}</strong></small> @endif
                    @if($maintenance->approved_by_eko) <br><small>Ka.Sub.bag.: <strong>{{ $maintenance->approved_by_eko }}</strong></small> @endif
                @endif
            </div>

            {{-- FORM FAJAR (Tahap 1) --}}
            @if(!$isEko && $maintenance->status_surat === 'menunggu_acc')
            <div class="card shadow mb-4 border-top border-success border-3">
                <div class="card-header py-3 bg-success bg-opacity-10">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-check-circle me-1"></i> Setujui Surat — Tahap 1 (Kabag)</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Upload scan surat pengantar yang sudah ditandatangani Kabag.</p>
                    <form action="{{ route('kabag.approve', $maintenance) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Surat TTD Kabag (PDF) <span class="text-danger">*</span></label>
                            <input type="file" name="file_surat_ttd" class="form-control" accept=".pdf" required>
                            <small class="text-muted">Format PDF. Maks 5MB</small>
                        </div>
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Setujui surat pengantar ini?')">
                            <i class="fas fa-check me-1"></i> Setujui & Upload Surat TTD
                        </button>
                    </form>
                </div>
            </div>

            {{-- FORM EKO (Tahap 2) --}}
            @elseif($isEko && $maintenance->status_surat === 'menunggu_eko')
            <div class="card shadow mb-4 border-top border-success border-3">
                <div class="card-header py-3 bg-success bg-opacity-10">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-check-circle me-1"></i> Verifikasi Surat — Tahap 2 (Ka.Sub.bag.)</h6>
                </div>
                <div class="card-body">
                    @if($maintenance->file_surat_ttd)
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Surat TTD Kabag:</label><br>
                        <a href="{{ asset('storage/' . $maintenance->file_surat_ttd) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-file-pdf me-1"></i> Lihat Surat TTD Kabag
                        </a>
                    </div>
                    @endif
                    <p class="text-muted small">Upload scan surat pengantar yang sudah ditandatangani Ka.Sub.bag. Umum & PDE.</p>
                    <form action="{{ route('kabag.approve-eko', $maintenance) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Surat TTD Ka.Sub.bag. (PDF) <span class="text-danger">*</span></label>
                            <input type="file" name="file_surat_ttd_eko" class="form-control" accept=".pdf" required>
                            <small class="text-muted">Format PDF. Maks 5MB</small>
                        </div>
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Verifikasi surat pengantar ini?')">
                            <i class="fas fa-check me-1"></i> Verifikasi & Upload Surat TTD
                        </button>
                    </form>
                </div>
            </div>

            {{-- Sudah selesai --}}
            @elseif($maintenance->status_surat === 'disetujui')
            <div class="alert alert-success">
                <i class="fas fa-check-double me-1"></i> Surat telah selesai diverifikasi oleh kedua pihak.
                @if($maintenance->file_surat_ttd)
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $maintenance->file_surat_ttd) }}" target="_blank" class="btn btn-sm btn-outline-success me-2">
                        <i class="fas fa-file-pdf me-1"></i> TTD Kabag
                    </a>
                    @if($maintenance->file_surat_ttd_eko)
                    <a href="{{ asset('storage/' . $maintenance->file_surat_ttd_eko) }}" target="_blank" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-file-pdf me-1"></i> TTD Ka.Sub.bag.
                    </a>
                    @endif
                </div>
                @endif
            </div>
            @else
            <div class="alert alert-secondary">
                <i class="fas fa-info-circle me-1"></i> Tidak ada aksi yang tersedia untuk Anda pada tahap ini.
            </div>
            @endif

            {{-- FORM TOLAK (Fajar tahap 1 atau Eko tahap 2) --}}
            @if((!$isEko && $maintenance->status_surat === 'menunggu_acc') || ($isEko && $maintenance->status_surat === 'menunggu_eko'))
            <div class="card shadow border-top border-danger border-3">
                <div class="card-header py-3 bg-danger bg-opacity-10">
                    <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-times-circle me-1"></i> Tolak Surat</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('kabag.reject', $maintenance) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="alasan_tolak" class="form-control" rows="3" required placeholder="Jelaskan alasan penolakan..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Tolak surat pengantar ini?')">
                            <i class="fas fa-times me-1"></i> Tolak Surat
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection