@extends('layouts.app')

@section('title', 'Detail Aset')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Aset</h1>

        <div>
            @if($asset->kategori == 'Kendaraan')
                <a href="{{ route('vehicles.show', $asset) }}" class="btn btn-info">
                    <i class="fas fa-car"></i> Detail Kendaraan
                </a>
            @endif

            <a href="{{ route('assets.sticker', $asset) }}" class="btn btn-success" target="_blank">
                <i class="fas fa-print"></i> Cetak Stiker
            </a>

            <a href="{{ route('assets.edit', $asset) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('assets.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- kiri -->
        <div class="col-lg-8">

            <!-- kartu info aset -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Aset</h6>

                    <!-- badge status kabag -->
                    @if(isset($asset->vehicleMaintenance))
                        @if($asset->vehicleMaintenance->is_acc_kabag)
                            <span class="badge bg-success">ACC Kabag</span>
                        @else
                            <span class="badge bg-warning text-dark">Menunggu ACC Kabag</span>
                        @endif
                    @endif
                </div>

                <div class="card-body">

                    <!-- tombol acc kabag -->
                    @if(auth()->check()
                        && auth()->user()->email === 'fajar@gmail.com'
                        && isset($asset->vehicleMaintenance)
                        && !$asset->vehicleMaintenance->is_acc_kabag)

                        <form action="{{ route('kabag.acc', $asset->vehicleMaintenance->id) }}"
                              method="POST"
                              class="mb-3">
                            @csrf
                            @method('PATCH')

                            <button class="btn btn-success">
                                <i class="fas fa-check"></i> ACC Kabag
                            </button>
                        </form>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Kode Aset</label>
                            <p class="fw-bold">{{ $asset->kode_aset }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Nama Aset</label>
                            <p class="fw-bold">{{ $asset->nama_aset }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Kategori</label>
                            <p><span class="badge bg-info">{{ $asset->kategori }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Kondisi</label>
                            <p>
                                @if($asset->kondisi == 'Baik')
                                    <span class="badge bg-success">{{ $asset->kondisi }}</span>
                                @elseif($asset->kondisi == 'Rusak Ringan')
                                    <span class="badge bg-warning">{{ $asset->kondisi }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $asset->kondisi }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Merk</label>
                            <p>{{ $asset->merk ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Tipe</label>
                            <p>{{ $asset->tipe ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Tahun Perolehan</label>
                            <p>{{ $asset->tahun_perolehan }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Nilai Perolehan</label>
                            <p class="fw-bold text-success">
                                Rp {{ number_format($asset->nilai_perolehan, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Lokasi</label>
                            <p>{{ $asset->lokasi }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Pemegang Saat Ini</label>
                            <p class="fw-bold">{{ $asset->pemegang_saat_ini ?? '-' }}</p>
                        </div>
                    </div>

                    @if($asset->keterangan)
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="text-muted small">Keterangan</label>
                                <p>{{ $asset->keterangan }}</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>

        <!-- kanan -->
        <div class="col-lg-4">

            <!-- foto -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Aset</h6>
                </div>
                <div class="card-body text-center">
                    @if($asset->foto)
                        <img src="{{ asset('storage/' . $asset->foto) }}"
                             alt="Foto Aset"
                             class="img-fluid rounded mb-3">
                    @else
                        <div class="bg-light p-5 rounded">
                            <i class="fas fa-image fa-3x text-muted"></i>
                            <p class="text-muted mt-2">Tidak ada foto</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- qr -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">QR Code</h6>
                </div>
                <div class="card-body text-center">
                    @if($asset->qr_code)
                        <img src="{{ asset('storage/' . $asset->qr_code) }}"
                             alt="QR Code"
                             class="img-fluid"
                             style="max-width:200px;">
                        <p class="text-muted small mt-2">
                            Scan untuk melihat detail aset
                        </p>
                    @else
                        <div class="bg-light p-4 rounded">
                            <i class="fas fa-qrcode fa-3x text-muted"></i>
                            <p class="text-muted mt-2">QR Code tidak tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
