@extends('layouts.app')

@section('title', 'Detail ' . $asset->kategori)

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail {{ $asset->kategori }}: {{ $asset->nama_aset }}</h1>
        <a href="{{ route('assets.show', $asset) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#identitas">
                <i class="fas fa-id-card"></i> Identitas {{ $asset->kategori }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#pemeliharaan">
                <i class="fas fa-tools"></i> Data Pemeliharaan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#statistik">
                <i class="fas fa-chart-pie"></i> Statistik Biaya
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#penyusutan">
                <i class="fas fa-chart-line"></i> Penyusutan
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Tab Identitas -->
        <div id="identitas" class="tab-pane fade show active">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Identitas {{ $asset->kategori }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('asset-details.update-detail', $asset) }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Info umum dari tabel assets --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Aset</label>
                                <input type="text" class="form-control" value="{{ $asset->nama_aset }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kode Aset</label>
                                <input type="text" class="form-control" value="{{ $asset->kode_aset }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <input type="text" class="form-control" value="{{ $asset->kategori }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kondisi</label>
                                <input type="text" class="form-control" value="{{ $asset->kondisi }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tahun Perolehan</label>
                                <input type="text" class="form-control" value="{{ $asset->tahun_perolehan }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nilai Perolehan</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($asset->nilai_perolehan, 0, ',', '.') }}" disabled>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-primary mb-3">Detail Spesifik {{ $asset->kategori }}</h6>
                        <div class="row">
                            @if($asset->kategori === 'Bangunan')
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Luas Bangunan (m²)</label>
                                    <input type="text" name="luas_bangunan" class="form-control" value="{{ $asset->assetDetail?->luas_bangunan }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah Lantai</label>
                                    <input type="text" name="jumlah_lantai" class="form-control" value="{{ $asset->assetDetail?->jumlah_lantai }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Konstruksi</label>
                                    <input type="text" name="konstruksi" class="form-control" placeholder="Beton/Kayu/Semi Permanen" value="{{ $asset->assetDetail?->konstruksi }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor IMB</label>
                                    <input type="text" name="nomor_imb" class="form-control" value="{{ $asset->assetDetail?->nomor_imb }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal IMB</label>
                                    <input type="date" name="tanggal_imb" class="form-control" value="{{ $asset->assetDetail?->tanggal_imb }}">
                                </div>

                            @elseif($asset->kategori === 'Tanah')
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Luas Tanah (m²)</label>
                                    <input type="text" name="luas_tanah" class="form-control" value="{{ $asset->assetDetail?->luas_tanah }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Sertifikat</label>
                                    <select name="jenis_sertifikat" class="form-select">
                                        <option value="">Pilih</option>
                                        @foreach(['SHM','HGB','HGU','HPL','HP','Girik'] as $j)
                                        <option value="{{ $j }}" {{ $asset->assetDetail?->jenis_sertifikat == $j ? 'selected' : '' }}>{{ $j }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Sertifikat</label>
                                    <input type="text" name="nomor_sertifikat" class="form-control" value="{{ $asset->assetDetail?->nomor_sertifikat }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Sertifikat</label>
                                    <input type="date" name="tanggal_sertifikat" class="form-control" value="{{ $asset->assetDetail?->tanggal_sertifikat }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Berlaku Sampai</label>
                                    <input type="date" name="berlaku_sampai" class="form-control" value="{{ $asset->assetDetail?->berlaku_sampai }}">
                                </div>

                            @else {{-- Peralatan, Inventaris, dll --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Seri</label>
                                    <input type="text" name="nomor_seri" class="form-control" value="{{ $asset->assetDetail?->nomor_seri }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Spesifikasi</label>
                                    <input type="text" name="spesifikasi" class="form-control" value="{{ $asset->assetDetail?->spesifikasi }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Garansi Sampai</label>
                                    <input type="text" name="garansi_sampai" class="form-control" placeholder="Contoh: Desember 2026" value="{{ $asset->assetDetail?->garansi_sampai }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lokasi Detail</label>
                                    <input type="text" name="lokasi_detail" class="form-control" value="{{ $asset->assetDetail?->lokasi_detail }}">
                                </div>
                            @endif

                            <div class="col-12 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan" class="form-control" rows="2">{{ $asset->assetDetail?->catatan }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Detail
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tab Pemeliharaan -->
        <div id="pemeliharaan" class="tab-pane fade">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pemeliharaan</h6>
                </div>
                <div class="card-body">
                    <!-- Form tambah pemeliharaan -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-plus"></i> Tambah Data Pemeliharaan</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('asset-details.store-maintenance', $asset) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Jenis Pemeliharaan <span class="text-danger">*</span></label>
                                        <select name="jenis_pemeliharaan" class="form-select" required>
                                            <option value="">Pilih</option>
                                            @if($asset->kategori === 'Bangunan')
                                                @foreach(['Renovasi', 'Perbaikan', 'Pengecatan', 'Pembersihan', 'Pengecekan Struktur', 'Lainnya'] as $j)
                                                <option value="{{ $j }}">{{ $j }}</option>
                                                @endforeach
                                            @elseif($asset->kategori === 'Tanah')
                                                @foreach(['Pembersihan Lahan', 'Pagar/Batas', 'Pengecekan Sertifikat', 'Lainnya'] as $j)
                                                <option value="{{ $j }}">{{ $j }}</option>
                                                @endforeach
                                            @else
                                                @foreach(['Perbaikan', 'Penggantian Komponen', 'Kalibrasi', 'Pembersihan', 'Pengecekan Rutin', 'Lainnya'] as $j)
                                                <option value="{{ $j }}">{{ $j }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Biaya (Rp)</label>
                                        <input type="number" name="biaya" class="form-control" min="0" value="0">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Vendor</label>
                                        <input type="text" name="vendor" class="form-control" placeholder="Nama vendor/kontraktor">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <input type="text" name="keterangan" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Upload Nota/Dokumen</label>
                                        <input type="file" name="file_nota" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Pemeliharaan
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Tabel riwayat pemeliharaan -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Keterangan</th>
                                    <th>Vendor</th>
                                    <th>Biaya</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($maintenances as $m)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($m->tanggal)->format('d/m/Y') }}</td>
                                    <td><span class="badge bg-secondary">{{ $m->jenis_pemeliharaan }}</span></td>
                                    <td>{{ $m->keterangan ?? '-' }}</td>
                                    <td>{{ $m->vendor ?? '-' }}</td>
                                    <td class="fw-bold">Rp {{ number_format($m->biaya, 0, ',', '.') }}</td>
                                    <td>
                                        @if($m->file_nota)
                                        <a href="{{ asset('storage/' . $m->file_nota) }}" target="_blank" class="btn btn-sm btn-light border">
                                            <i class="fas fa-file"></i>
                                        </a>
                                        @endif
                                        <form action="{{ route('asset-details.delete-maintenance', [$asset, $m]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data pemeliharaan</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Statistik -->
        <div id="statistik" class="tab-pane fade">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow border-left-primary">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Biaya Pemeliharaan</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @if($biayaPerJenis->isNotEmpty())
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Biaya per Jenis Pemeliharaan</h6>
                </div>
                <div class="card-body">
                    <canvas id="costChart"></canvas>
                </div>
            </div>
            @endif
        </div>

        <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-secondary">
            <i class="fas fa-history me-1"></i> Histori Perubahan Data Aset
        </h6>
        @if($asset->changeLogs->count())
        <span class="badge bg-secondary">{{ $asset->changeLogs->count() }} perubahan</span>
        @endif
    </div>
    <div class="card-body p-0">
        @if($asset->changeLogs->count())
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Field</th>
                        <th>Nilai Lama</th>
                        <th>Nilai Baru</th>
                        <th>Diubah Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asset->changeLogs as $log)
                    <tr>
                        <td class="text-muted small">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $log->field_label }}</span></td>
                        <td>
                            @if($log->field_name === 'nilai_perolehan')
                                <span class="text-muted">Rp {{ number_format($log->old_value, 0, ',', '.') }}</span>
                            @else
                                <span class="text-muted">{{ $log->old_value ?? '-' }}</span>
                            @endif
                        </td>
                        <td>
                            @if($log->field_name === 'nilai_perolehan')
                                <strong>Rp {{ number_format($log->new_value, 0, ',', '.') }}</strong>
                            @elseif($log->field_name === 'kondisi')
                                @php $kondisiClass = ['Baik'=>'success','Rusak Ringan'=>'warning','Rusak Berat'=>'danger'][$log->new_value] ?? 'secondary'; @endphp
                                <span class="badge bg-{{ $kondisiClass }}">{{ $log->new_value }}</span>
                            @else
                                <strong>{{ $log->new_value ?? '-' }}</strong>
                            @endif
                        </td>
                        <td class="small">{{ $log->changed_by }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4 text-muted">
            <i class="fas fa-history fa-2x mb-2 d-block text-light"></i>
            Belum ada perubahan data yang tercatat.
        </div>
        @endif
    </div>
</div>

        <!-- Tab Penyusutan -->
        <div id="penyusutan" class="tab-pane fade">
            @php
                $namasBulan  = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                $namasBulanP = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
                $lastDep     = $depreciationDetails->last();
                if ($lastDep) {
                    $nextBulan = ($lastDep->bulan % 12) + 1;
                    $nextTahun = $lastDep->bulan == 12 ? $lastDep->tahun + 1 : $lastDep->tahun;
                } else {
                    $nextBulan = 1;
                    $nextTahun = $depreciation?->tahun_mulai ?? date('Y');
                }
            @endphp

            <div class="row">
                {{-- Kolom kiri: konfigurasi + form tambah --}}
                <div class="col-md-4">
                    {{-- Konfigurasi --}}
                    <div class="card shadow mb-3">
                        <div class="card-header py-2 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold text-primary"><i class="fas fa-cog me-1"></i> Konfigurasi</h6>
                            @if($depreciation)
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#formKonfigDep">
                                <i class="fas fa-edit"></i>
                            </button>
                            @endif
                        </div>
                        <div class="card-body {{ $depreciation ? 'collapse' : '' }}" id="formKonfigDep">
                            <form action="{{ route('depreciations.store', $asset) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Metode</label>
                                    <select name="metode" class="form-select" required>
                                        <option value="garis_lurus" {{ $depreciation?->metode=='garis_lurus'?'selected':'' }}>Garis Lurus</option>
                                        <option value="saldo_menurun" {{ $depreciation?->metode=='saldo_menurun'?'selected':'' }}>Saldo Menurun</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Umur Ekonomis (tahun)</label>
                                    <input type="number" name="umur_ekonomis" class="form-control" value="{{ $depreciation?->umur_ekonomis ?? 5 }}" min="1" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Nilai Sisa (Rp)</label>
                                    <input type="number" name="nilai_sisa" class="form-control" value="{{ $depreciation?->nilai_sisa ?? 0 }}" min="0" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Tahun Mulai</label>
                                    <input type="number" name="tahun_mulai" class="form-control" value="{{ $depreciation?->tahun_mulai ?? date('Y') }}" min="1900" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-1"></i> Simpan Konfigurasi
                                </button>
                            </form>
                        </div>
                        @if($depreciation)
                        <div class="card-body pt-0">
                            <table class="table table-sm table-borderless mb-0 small">
                                <tr><td class="text-muted">Metode</td><td><strong>{{ $depreciation->metode=='garis_lurus'?'Garis Lurus':'Saldo Menurun' }}</strong></td></tr>
                                <tr><td class="text-muted">Umur Ekonomis</td><td><strong>{{ $depreciation->umur_ekonomis }} tahun</strong></td></tr>
                                <tr><td class="text-muted">Nilai Sisa</td><td><strong>Rp {{ number_format($depreciation->nilai_sisa, 0, ',', '.') }}</strong></td></tr>
                                <tr><td class="text-muted">Nilai Buku Kini</td><td><strong class="text-success">Rp {{ number_format($lastDep?->nilai_buku ?? $asset->nilai_perolehan, 0, ',', '.') }}</strong></td></tr>
                                <tr><td class="text-muted">Total Disusutkan</td><td><strong class="text-danger">Rp {{ number_format($depreciationDetails->sum('beban_penyusutan'), 0, ',', '.') }}</strong></td></tr>
                            </table>
                        </div>
                        @endif
                    </div>

                    {{-- Form tambah per bulan --}}
                    @if($depreciation)
                    <div class="card shadow border-primary">
                        <div class="card-header bg-light py-2">
                            <h6 class="m-0 fw-bold text-primary"><i class="fas fa-plus me-1"></i> Tambah Data Penyusutan</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('depreciations.add-detail', $asset) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Bulan</label>
                                    <select name="bulan" class="form-select" required>
                                        @foreach($namasBulan as $num => $nama)
                                        <option value="{{ $num }}" {{ $nextBulan==$num?'selected':'' }}>{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Tahun</label>
                                    <input type="number" name="tahun" class="form-control" value="{{ $nextTahun }}" min="2000" max="2100" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Nilai Awal Bulan (Rp)</label>
                                    <input type="number" name="nilai_awal" class="form-control" value="{{ $lastDep?->nilai_buku ?? $asset->nilai_perolehan }}" min="0" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Beban Penyusutan (Rp)</label>
                                    <input type="number" name="beban_penyusutan" class="form-control" min="0" required placeholder="Isi manual">
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-plus me-1"></i> Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Kolom kanan: tabel + grafik --}}
                <div class="col-md-8">
                    @if($depreciationDetails->count())
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Penyusutan per Bulan</h6>
                            <small class="text-muted">Metode: <strong>{{ $depreciation->metode=='garis_lurus'?'Garis Lurus':'Saldo Menurun' }}</strong></small>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Periode</th>
                                            <th>Nilai Awal</th>
                                            <th>Beban Penyusutan</th>
                                            <th>Akumulasi</th>
                                            <th>Nilai Buku</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($depreciationDetails as $d)
                                        <tr>
                                            <td><strong>{{ $namasBulanP[$d->bulan] ?? '-' }} {{ $d->tahun }}</strong></td>
                                            <td>Rp {{ number_format($d->nilai_awal, 0, ',', '.') }}</td>
                                            <td class="text-danger">- Rp {{ number_format($d->beban_penyusutan, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($d->akumulasi_penyusutan, 0, ',', '.') }}</td>
                                            <td><strong>Rp {{ number_format($d->nilai_buku, 0, ',', '.') }}</strong></td>
                                            <td>
                                                <form action="{{ route('depreciations.delete-detail', [$asset, $d]) }}" method="POST"
                                                    onsubmit="return confirm('Hapus {{ $namasBulanP[$d->bulan] ?? '' }} {{ $d->tahun }}?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Nilai Buku</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="depreciationChart"></canvas>
                        </div>
                    </div>
                    @else
                    <div class="card shadow">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted">Belum ada data penyusutan. Tambahkan data per bulan di form sebelah kiri.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($biayaPerJenis->isNotEmpty())
const ctx = document.getElementById('costChart');
if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($biayaPerJenis->keys()) !!},
            datasets: [{ label: 'Biaya (Rp)', data: {!! json_encode($biayaPerJenis->values()) !!}, backgroundColor: '#4e73df' }]
        },
        options: { responsive: true, scales: { y: { ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } } }
    });
}
@endif

@if(isset($depreciationDetails) && $depreciationDetails->count())
@php
    $depSorted = $depreciationDetails->sortBy(fn($d) => $d->tahun * 100 + ($d->bulan ?? 0));
    $depLabels = $depSorted->map(function($d) {
        $b = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
        return ($b[$d->bulan] ?? '-').' '.$d->tahun;
    })->values();
@endphp
const depCtx = document.getElementById('depreciationChart');
if (depCtx) {
    new Chart(depCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($depLabels) !!},
            datasets: [{
                label: 'Nilai Buku (Rp)',
                data: {!! json_encode($depSorted->pluck('nilai_buku')->values()) !!},
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78,115,223,0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: { y: { ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } }
        }
    });
}
@endif
</script>
@endpush
@endsection