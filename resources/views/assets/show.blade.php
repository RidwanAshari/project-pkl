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
                                    <option value="{{ $user->name }}"
                                        data-jabatan="{{ $user->position ?? '' }}">
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
// Auto-fill jabatan dari dropdown penerima
document.querySelector('select[name="ke_pemegang"]').addEventListener('change', function() {
    const jabatan = this.options[this.selectedIndex].getAttribute('data-jabatan');
    document.getElementById('jabatan_ke').value = jabatan ? ucfirstStr(jabatan) : '';
});

function ucfirstStr(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}
</script>
@endpush
@endsection