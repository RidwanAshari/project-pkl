@extends('layouts.app')

@section('title', 'Detail Aset')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Aset</h1>
        <div>
            {{-- Tombol detail sesuai kategori --}}
            @if($asset->kategori == 'Kendaraan')
            <a href="{{ route('vehicles.show', $asset) }}" class="btn btn-info">
                <i class="fas fa-car"></i> Detail Kendaraan
            </a>
            @elseif(in_array($asset->kategori, ['Peralatan', 'Inventaris', 'Inventaris Barang dan Perabot Kantor', 'Gedung', 'Tanah', 'Bangunan']))
            <a href="{{ route('asset-details.show', $asset) }}" class="btn btn-info">
                <i class="fas fa-clipboard-list"></i> Detail {{ $asset->kategori }}
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
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Info Aset -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Aset</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Kode Aset</label>
                            <p class="fw-bold">{{ $asset->kode_aset ?? '-' }}</p>
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
                            <p class="fw-bold text-success">Rp {{ number_format($asset->nilai_perolehan, 0, ',', '.') }}</p>
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

            <!-- Histori Pemegang -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Histori Pemegang Aset</h6>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#transferModal">
                        <i class="fas fa-exchange-alt"></i> Transfer Aset
                    </button>
                </div>
                <div class="card-body">
                    @if($asset->histories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No. BA</th>
                                    <th>Dari</th>
                                    <th>Ke</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asset->histories()->latest()->get() as $history)
                                <tr>
                                    <td>
                                        {{ $history->nomor_ba }}
                                        <a href="{{ route('history.download-ba', $history) }}" class="btn btn-sm btn-danger ms-2" title="Download BA">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
                                    <td>{{ $history->dari_pemegang ?? '-' }}</td>
                                    <td><strong>{{ $history->ke_pemegang }}</strong></td>
                                    <td>{{ $history->tanggal_serah_terima->format('d/m/Y') }}</td>
                                    <td>{{ $history->keterangan ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-center text-muted py-3">Belum ada histori transfer</p>
                    @endif
                </div>
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

            {{-- ===== PENYUSUTAN PER BULAN ===== --}}
            @php
                $depreciation = $asset->depreciation ?? null;
                $depDetails   = $depreciation?->details ?? collect();
                $namasBulan   = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                $namasBulanP  = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
                $lastDep      = $depDetails->sortBy(fn($d) => $d->tahun * 100 + ($d->bulan ?? 0))->last();
                if ($lastDep) {
                    $nextBulan = ($lastDep->bulan % 12) + 1;
                    $nextTahun = $lastDep->bulan == 12 ? $lastDep->tahun + 1 : $lastDep->tahun;
                } else {
                    $nextBulan = 1;
                    $nextTahun = $depreciation?->tahun_mulai ?? date('Y');
                }
            @endphp
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-line me-1"></i> Penyusutan Aset</h6>
                    <button class="btn btn-sm btn-outline-{{ $depreciation ? 'secondary' : 'primary' }}" data-bs-toggle="collapse" data-bs-target="#formKonfigDep">
                        <i class="fas fa-{{ $depreciation ? 'edit' : 'cog' }} me-1"></i> {{ $depreciation ? 'Ubah' : 'Atur' }} Konfigurasi
                    </button>
                </div>
                <div class="card-body">
                    <div class="collapse {{ !$depreciation ? 'show' : '' }}" id="formKonfigDep">
                        <div class="card border mb-3"><div class="card-body">
                            <form action="{{ route('depreciations.store', $asset) }}" method="POST">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-3"><label class="form-label fw-semibold">Metode</label>
                                        <select name="metode" class="form-select" required>
                                            <option value="garis_lurus" {{ $depreciation?->metode=='garis_lurus'?'selected':'' }}>Garis Lurus</option>
                                            <option value="saldo_menurun" {{ $depreciation?->metode=='saldo_menurun'?'selected':'' }}>Saldo Menurun</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2"><label class="form-label fw-semibold">Umur Ekonomis</label>
                                        <input type="number" name="umur_ekonomis" class="form-control" value="{{ $depreciation?->umur_ekonomis ?? 5 }}" min="1" required>
                                    </div>
                                    <div class="col-md-3"><label class="form-label fw-semibold">Nilai Sisa (Rp)</label>
                                        <input type="number" name="nilai_sisa" class="form-control" value="{{ $depreciation?->nilai_sisa ?? 0 }}" min="0" required>
                                    </div>
                                    <div class="col-md-2"><label class="form-label fw-semibold">Tahun Mulai</label>
                                        <input type="number" name="tahun_mulai" class="form-control" value="{{ $depreciation?->tahun_mulai ?? date('Y') }}" min="1900" required>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i> Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div></div>
                    </div>

                    @if($depreciation)
                    <div class="row mb-3 text-center">
                        <div class="col-md-4"><small class="text-muted d-block">Metode</small><strong>{{ $depreciation->metode=='garis_lurus'?'Garis Lurus':'Saldo Menurun' }}</strong></div>
                        <div class="col-md-4"><small class="text-muted d-block">Nilai Buku Saat Ini</small><strong class="text-success">Rp {{ number_format($lastDep?->nilai_buku ?? $asset->nilai_perolehan, 0, ',', '.') }}</strong></div>
                        <div class="col-md-4"><small class="text-muted d-block">Total Disusutkan</small><strong class="text-danger">Rp {{ number_format($depDetails->sum('beban_penyusutan'), 0, ',', '.') }}</strong></div>
                    </div>

                    <div class="card border-primary mb-3"><div class="card-header bg-light py-2">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-plus me-1"></i> Tambah Data Penyusutan Bulanan</h6>
                    </div><div class="card-body">
                        <form action="{{ route('depreciations.add-detail', $asset) }}" method="POST">
                            @csrf
                            <div class="row g-2">
                                <div class="col-md-3"><label class="form-label fw-semibold">Bulan</label>
                                    <select name="bulan" class="form-select" required>
                                        @foreach($namasBulan as $num => $nama)
                                        <option value="{{ $num }}" {{ $nextBulan==$num?'selected':'' }}>{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2"><label class="form-label fw-semibold">Tahun</label>
                                    <input type="number" name="tahun" class="form-control" value="{{ $nextTahun }}" min="2000" max="2100" required>
                                </div>
                                <div class="col-md-3"><label class="form-label fw-semibold">Nilai Awal (Rp)</label>
                                    <input type="number" name="nilai_awal" class="form-control" value="{{ $lastDep?->nilai_buku ?? $asset->nilai_perolehan }}" min="0" required>
                                </div>
                                <div class="col-md-3"><label class="form-label fw-semibold">Beban Penyusutan (Rp)</label>
                                    <input type="number" name="beban_penyusutan" class="form-control" min="0" required placeholder="Isi manual">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success w-100"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </form>
                    </div></div>

                    @if($depDetails->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="table-primary">
                                <tr><th>Periode</th><th>Nilai Awal</th><th>Beban Penyusutan</th><th>Akumulasi</th><th>Nilai Buku</th><th></th></tr>
                            </thead>
                            <tbody>
                                @foreach($depDetails->sortBy(fn($d) => $d->tahun * 100 + ($d->bulan ?? 0)) as $d)
                                <tr>
                                    <td><strong>{{ $namasBulanP[$d->bulan] ?? '-' }} {{ $d->tahun }}</strong></td>
                                    <td>Rp {{ number_format($d->nilai_awal, 0, ',', '.') }}</td>
                                    <td class="text-danger">- Rp {{ number_format($d->beban_penyusutan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($d->akumulasi_penyusutan, 0, ',', '.') }}</td>
                                    <td><strong>Rp {{ number_format($d->nilai_buku, 0, ',', '.') }}</strong></td>
                                    <td>
                                        <form action="{{ route('depreciations.delete-detail', [$asset, $d]) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-center text-muted py-3"><i class="fas fa-chart-line me-2"></i>Belum ada data. Tambahkan per bulan di atas.</p>
                    @endif
                    @endif
                </div>
            </div>

        </div>

        <!-- Foto & QR Code -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Aset</h6>
                </div>
                <div class="card-body text-center">
                    @if($asset->foto)
                        <img src="{{ asset('storage/' . $asset->foto) }}" alt="Foto Aset" class="img-fluid rounded mb-3">
                    @else
                        <div class="bg-light p-5 rounded">
                            <i class="fas fa-image fa-3x text-muted"></i>
                            <p class="text-muted mt-2">Tidak ada foto</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">QR Code</h6>
                </div>
                <div class="card-body text-center">
                    @if($asset->qr_code)
                        <img src="{{ asset('storage/' . $asset->qr_code) }}" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                        <p class="text-muted small mt-2">Scan untuk melihat detail aset</p>
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

<!-- Modal Transfer Aset -->
<div class="modal fade" id="transferModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-exchange-alt me-2"></i>Transfer Aset — Isi Data Berita Acara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('assets.transfer', $asset) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Serah Terima <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_serah_terima" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <hr>
                    <h6 class="text-primary mb-3"><i class="fas fa-user me-1"></i> PIHAK PERTAMA (Yang Menyerahkan)</h6>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" value="{{ $asset->pemegang_saat_ini ?? 'Bagian Pengadaan' }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jabatan Pihak Pertama</label>
                            <select name="jabatan_dari" class="form-select">
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="Direktur Utama">Direktur Utama</option>
                                <option value="Direktur">Direktur</option>
                                <option value="Ka Sub Bag Umum & PDE">Ka Sub Bag Umum &amp; PDE</option>
                                <option value="Ka Sub Bag Keuangan">Ka Sub Bag Keuangan</option>
                                <option value="Ka Sub Bag SDM">Ka Sub Bag SDM</option>
                                <option value="Ka Sub Unit Banjarnegoro">Ka Sub Unit Banjarnegoro</option>
                                <option value="Ka Sub Unit Mertoyudan">Ka Sub Unit Mertoyudan</option>
                                <option value="Ka Sub Unit Muntilan">Ka Sub Unit Muntilan</option>
                                <option value="Ka Sub Unit Grabag">Ka Sub Unit Grabag</option>
                                <option value="Plt. Ka Sub Unit Banjarnegoro">Plt. Ka Sub Unit Banjarnegoro</option>
                                <option value="Plt. Ka Sub Unit Mertoyudan">Plt. Ka Sub Unit Mertoyudan</option>
                                <option value="Plt. Ka Sub Unit Muntilan">Plt. Ka Sub Unit Muntilan</option>
                                <option value="Staf Umum">Staf Umum</option>
                                <option value="Staf Keuangan">Staf Keuangan</option>
                                <option value="Staf Teknik">Staf Teknik</option>
                                <option value="Bagian Pengadaan">Bagian Pengadaan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIPP Pihak Pertama</label>
                            <input type="text" name="nipp_dari" class="form-control" placeholder="Contoh: 1912.0606.83">
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-success mb-3"><i class="fas fa-user me-1"></i> PIHAK KEDUA (Yang Menerima)</h6>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                            <select name="ke_pemegang" class="form-select" required>
                                <option value="">-- Pilih Penerima --</option>
                                @foreach(\App\Models\User::orderBy('name')->get() as $user)
                                    <option value="{{ $user->name }}" data-jabatan="{{ $user->position ?? '' }}">
                                        {{ $user->name }}{{ $user->position ? ' — ' . ucfirst($user->position) : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jabatan Pihak Kedua</label>
                            <input type="text" name="jabatan_ke" id="jabatan_ke" class="form-control" placeholder="Contoh: Ka Sub Bag Umum & PDE">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIPP Pihak Kedua</label>
                            <input type="text" name="nipp_ke" class="form-control" placeholder="Contoh: 1293.0903.78">
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Keterangan / Kondisi Aset</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: dikembalikan karena tidak dipakai / rusak"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file-alt me-1"></i> Buat Berita Acara & Transfer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelector('select[name="ke_pemegang"]').addEventListener('change', function() {
    const jabatan = this.options[this.selectedIndex].getAttribute('data-jabatan');
    document.getElementById('jabatan_ke').value = jabatan ? jabatan.charAt(0).toUpperCase() + jabatan.slice(1) : '';
});
</script>
@endpush
@endsection