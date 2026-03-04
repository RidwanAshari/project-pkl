@extends('layouts.app')
@section('title', 'Verifikasi Surat Pengantar')
@section('content')
<div class="container-fluid px-4">
    <h1 class="h3 mb-4 text-gray-800">Verifikasi Surat Pengantar</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Statistik --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow border-left-warning">
                <div class="card-body py-3">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Kabag</div>
                    <div class="h3 mb-0 font-weight-bold text-warning">{{ $menungguAcc->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow border-left-info">
                <div class="card-body py-3">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Menunggu Ka.Sub.bag.</div>
                    <div class="h3 mb-0 font-weight-bold text-info">{{ $menungguEko->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow border-left-success">
                <div class="card-body py-3">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai Diverifikasi</div>
                    <div class="h3 mb-0 font-weight-bold text-success">{{ $sudahDisetujui->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow border-left-danger">
                <div class="card-body py-3">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                    <div class="h3 mb-0 font-weight-bold text-danger">{{ $ditolak->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TAHAP 1: Hanya Fajar --}}
    @if($isFajar)
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center gap-2">
            <span class="badge bg-warning text-dark fs-6">{{ $menungguAcc->count() }}</span>
            <h6 class="m-0 font-weight-bold text-warning">
                <i class="fas fa-clock me-1"></i> Tahap 1 — Menunggu Persetujuan Kabag
            </h6>
        </div>
        <div class="card-body">
            @if($menungguAcc->isEmpty())
            <div class="text-center py-3 text-muted"><i class="fas fa-check-circle text-success me-1"></i> Tidak ada surat menunggu.</div>
            @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr><th>Tanggal</th><th>Kendaraan</th><th>Jenis Servis</th><th>Bengkel</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @foreach($menungguAcc as $m)
                        <tr>
                            <td>{{ $m->tanggal->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $m->asset->nama_aset }}</strong><br>
                                <small class="text-muted">{{ $m->asset->kode_aset }}</small>
                            </td>
                            <td><span class="badge bg-primary">{{ $m->jenis_servis }}</span></td>
                            <td>{{ $m->bengkel ?? '-' }}</td>
                            <td>
                                <a href="{{ route('kabag.review-surat', $m) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-stamp me-1"></i> Review & Setujui
                                </a>
                            </td>
                        </tr>
                        {{-- Modal Approve Eko + Upload TTD --}}
                        <div class="modal fade" id="approveEkoModal{{ $m->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <div class="modal-header bg-success bg-opacity-10">
                                    <h5 class="modal-title text-success"><i class="fas fa-check-circle me-1"></i> Verifikasi Ka.Sub.bag.</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('kabag.approve-eko', $m) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-muted small mb-3">Upload scan surat pengantar yang sudah ditandatangani Ka.Sub.bag. Umum & PDE.</p>
                                        <label class="form-label fw-semibold">Upload Surat TTD (PDF) <span class="text-danger">*</span></label>
                                        <input type="file" name="file_surat_ttd_eko" class="form-control" accept=".pdf" required>
                                        <small class="text-muted">Format PDF. Maks 5MB</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check me-1"></i> Simpan & Verifikasi</button>
                                    </div>
                                </form>
                            </div></div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    @endif

    {{-- TAHAP 2: Hanya Eko --}}
    @if($isEko)
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center gap-2">
            <span class="badge bg-info fs-6">{{ $menungguEko->count() }}</span>
            <h6 class="m-0 font-weight-bold text-info">
                <i class="fas fa-user-check me-1"></i> Tahap 2 — Menunggu Verifikasi Ka.Sub.bag. Umum & PDE
            </h6>
        </div>
        <div class="card-body">
            @if($menungguEko->isEmpty())
            <div class="text-center py-3 text-muted"><i class="fas fa-check-circle text-success me-1"></i> Tidak ada surat menunggu.</div>
            @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr><th>Tanggal</th><th>Kendaraan</th><th>Jenis Servis</th><th>Disetujui Kabag</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @foreach($menungguEko as $m)
                        <tr>
                            <td>{{ $m->tanggal->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $m->asset->nama_aset }}</strong><br>
                                <small class="text-muted">{{ $m->asset->vehicleDetail?->nomor_plat ?? $m->asset->kode_aset }}</small>
                            </td>
                            <td><span class="badge bg-primary">{{ $m->jenis_servis }}</span></td>
                            <td>
                                <small class="text-success"><i class="fas fa-check me-1"></i>{{ $m->approved_by }}</small><br>
                                <small class="text-muted">{{ $m->approved_at?->format('d/m/Y H:i') }}</small>
                            </td>
                            <td class="d-flex gap-1">
                                {{-- Lihat surat yang sudah di-TTD Fajar --}}
                                @if($m->file_surat_ttd)
                                <a href="{{ asset('storage/' . $m->file_surat_ttd) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-pdf"></i> Lihat
                                </a>
                                @endif
                                {{-- Approve Eko - butuh upload dokumen --}}
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveEkoModal{{ $m->id }}">
                                    <i class="fas fa-check me-1"></i> Verifikasi
                                </button>
                                {{-- Tolak --}}
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $m->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Tolak --}}
                        <div class="modal fade" id="tolakModal{{ $m->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <div class="modal-header"><h5 class="modal-title">Tolak Surat</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <form action="{{ route('kabag.reject', $m) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <textarea name="alasan_tolak" class="form-control" rows="3" required placeholder="Alasan penolakan..."></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </div>
                                </form>
                            </div></div>
                        </div>
                        {{-- Modal Approve Eko + Upload TTD --}}
                        <div class="modal fade" id="approveEkoModal{{ $m->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <div class="modal-header bg-success bg-opacity-10">
                                    <h5 class="modal-title text-success"><i class="fas fa-check-circle me-1"></i> Verifikasi Ka.Sub.bag.</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('kabag.approve-eko', $m) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-muted small mb-3">Upload scan surat pengantar yang sudah ditandatangani Ka.Sub.bag. Umum & PDE.</p>
                                        <label class="form-label fw-semibold">Upload Surat TTD (PDF) <span class="text-danger">*</span></label>
                                        <input type="file" name="file_surat_ttd_eko" class="form-control" accept=".pdf" required>
                                        <small class="text-muted">Format PDF. Maks 5MB</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check me-1"></i> Simpan & Verifikasi</button>
                                    </div>
                                </form>
                            </div></div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    @endif

    {{-- Riwayat Disetujui --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-check-double me-1"></i> Selesai Diverifikasi (10 Terakhir)</h6>
        </div>
        <div class="card-body">
            @if($sudahDisetujui->isEmpty())
            <p class="text-muted text-center py-3">Belum ada surat yang selesai.</p>
            @else
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead class="table-light">
                        <tr><th>Tanggal</th><th>Kendaraan</th><th>Jenis Servis</th><th>Kabag</th><th>Ka.Sub.bag.</th><th>Surat</th></tr>
                    </thead>
                    <tbody>
                        @foreach($sudahDisetujui as $m)
                        <tr>
                            <td>{{ $m->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $m->asset->nama_aset }}</td>
                            <td>{{ $m->jenis_servis }}</td>
                            <td><small class="text-success">{{ $m->approved_by ?? '-' }}</small></td>
                            <td><small class="text-success">{{ $m->approved_by_eko ?? '-' }}</small></td>
                            <td>
                                @if($m->file_surat_ttd)
                                <a href="{{ asset('storage/' . $m->file_surat_ttd) }}" target="_blank" class="btn btn-xs btn-outline-success btn-sm">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        {{-- Modal Approve Eko + Upload TTD --}}
                        <div class="modal fade" id="approveEkoModal{{ $m->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <div class="modal-header bg-success bg-opacity-10">
                                    <h5 class="modal-title text-success"><i class="fas fa-check-circle me-1"></i> Verifikasi Ka.Sub.bag.</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('kabag.approve-eko', $m) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-muted small mb-3">Upload scan surat pengantar yang sudah ditandatangani Ka.Sub.bag. Umum & PDE.</p>
                                        <label class="form-label fw-semibold">Upload Surat TTD (PDF) <span class="text-danger">*</span></label>
                                        <input type="file" name="file_surat_ttd_eko" class="form-control" accept=".pdf" required>
                                        <small class="text-muted">Format PDF. Maks 5MB</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check me-1"></i> Simpan & Verifikasi</button>
                                    </div>
                                </form>
                            </div></div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection