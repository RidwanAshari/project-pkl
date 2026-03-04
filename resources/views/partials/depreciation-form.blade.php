{{-- resources/views/partials/depreciation-form.blade.php --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-line me-2"></i>Penyusutan Aset</h6>
        @if($depreciation)
        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#formKonfigurasi">
            <i class="fas fa-cog me-1"></i> Ubah Konfigurasi
        </button>
        @endif
    </div>
    <div class="card-body">

        @if(!$depreciation)
        {{-- Belum ada konfigurasi --}}
        <div class="alert alert-warning">
            <i class="fas fa-info-circle me-1"></i> Belum ada konfigurasi penyusutan. Isi form di bawah untuk memulai.
        </div>
        @endif

        {{-- Form konfigurasi (collapse jika sudah ada) --}}
        <div class="{{ $depreciation ? 'collapse' : '' }}" id="formKonfigurasi">
            <form action="{{ route('depreciations.store', $asset) }}" method="POST" class="mb-4">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Metode</label>
                        <select name="metode" class="form-select" required>
                            <option value="garis_lurus"   {{ ($depreciation->metode ?? '') == 'garis_lurus' ? 'selected' : '' }}>Garis Lurus</option>
                            <option value="saldo_menurun" {{ ($depreciation->metode ?? '') == 'saldo_menurun' ? 'selected' : '' }}>Saldo Menurun</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Umur Ekonomis (thn)</label>
                        <input type="number" name="umur_ekonomis" class="form-control" min="1" max="50"
                            value="{{ $depreciation->umur_ekonomis ?? 5 }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Nilai Sisa (Rp)</label>
                        <input type="number" name="nilai_sisa" class="form-control" min="0"
                            value="{{ $depreciation->nilai_sisa ?? 0 }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" class="form-control" min="2000" max="2100"
                            value="{{ $depreciation->tahun_mulai ?? $asset->tahun_perolehan }}" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
            <hr>
        </div>

        @if($depreciation)
        {{-- Info konfigurasi aktif --}}
        <div class="d-flex flex-wrap gap-3 mb-3">
            <span class="badge bg-primary fs-6">{{ $depreciation->metode == 'garis_lurus' ? 'Garis Lurus' : 'Saldo Menurun' }}</span>
            <span class="text-muted">Umur ekonomis: <strong>{{ $depreciation->umur_ekonomis }} thn</strong></span>
            <span class="text-muted">Nilai sisa: <strong>Rp {{ number_format($depreciation->nilai_sisa, 0, ',', '.') }}</strong></span>
            <span class="text-muted">Mulai: <strong>{{ $depreciation->tahun_mulai }}</strong></span>
        </div>

        {{-- Tabel histori penyusutan --}}
        @if($depreciationDetails->count() > 0)
        <div class="table-responsive mb-3">
            <table class="table table-sm table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Tahun</th>
                        <th>Nilai Awal</th>
                        <th>Beban Penyusutan</th>
                        <th>Akumulasi</th>
                        <th>Nilai Buku</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($depreciationDetails->sortBy('tahun') as $d)
                    <tr>
                        <td><strong>{{ $d->tahun }}</strong></td>
                        <td>Rp {{ number_format($d->nilai_awal, 0, ',', '.') }}</td>
                        <td class="text-danger">Rp {{ number_format($d->beban_penyusutan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($d->akumulasi_penyusutan, 0, ',', '.') }}</td>
                        <td class="fw-bold text-success">Rp {{ number_format($d->nilai_buku, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('depreciations.delete-detail', [$asset, $d]) }}" method="POST"
                                onsubmit="return confirm('Hapus data tahun {{ $d->tahun }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted mb-3"><i class="fas fa-info-circle me-1"></i> Belum ada data penyusutan per tahun. Tambahkan di bawah.</p>
        @endif

        {{-- Form tambah data per tahun --}}
        <div class="card border-primary">
            <div class="card-header bg-light py-2">
                <h6 class="m-0 fw-bold text-primary"><i class="fas fa-plus me-1"></i> Tambah Data Penyusutan Tahun Baru</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('depreciations.add-detail', $asset) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Tahun</label>
                            <input type="number" name="tahun" class="form-control" min="2000" max="2100"
                                value="{{ ($depreciationDetails->max('tahun') ?? $depreciation->tahun_mulai - 1) + 1 }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nilai Awal Tahun (Rp)</label>
                            <input type="number" name="nilai_awal" class="form-control" min="0"
                                value="{{ $depreciationDetails->sortByDesc('tahun')->first()?->nilai_buku ?? $asset->nilai_perolehan }}"
                                required>
                            <small class="text-muted">Nilai buku awal tahun ini</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Beban Penyusutan (Rp)</label>
                            <input type="number" name="beban_penyusutan" class="form-control" min="0" required
                                placeholder="Masukkan nilai penyusutan tahun ini">
                            <small class="text-muted">Diisi sesuai perhitungan akuntansi</small>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-plus me-1"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>