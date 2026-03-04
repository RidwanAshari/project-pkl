@extends('layouts.app')
@section('title', 'Buat DPB')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Buat Surat DPB</h1>
        <a href="{{ route('finance.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
    @endif

    <div class="row">
        {{-- Info sidebar --}}
        <div class="col-lg-3 mb-4">
            <div class="card shadow">
                <div class="card-header bg-light"><h6 class="m-0 fw-bold">Info Pemeliharaan</h6></div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td class="text-muted small">Kendaraan</td><td><strong>{{ $asset->nama_aset }}</strong></td></tr>
                        <tr><td class="text-muted small">Kode Aset</td><td>{{ $asset->kode_aset ?? '-' }}</td></tr>
                        <tr><td class="text-muted small">Jenis Servis</td><td>{{ $maintenance->jenis_servis }}</td></tr>
                        <tr><td class="text-muted small">Bengkel</td><td>{{ $maintenance->bengkel ?? '-' }}</td></tr>
                        <tr><td class="text-muted small">Tanggal</td><td>{{ \Carbon\Carbon::parse($maintenance->tanggal)->format('d/m/Y') }}</td></tr>
                        <tr><td class="text-muted small">Biaya Aktual</td><td><strong class="text-success">Rp {{ number_format($maintenance->biaya_aktual ?? 0, 0, ',', '.') }}</strong></td></tr>
                    </table>
                </div>
            </div>

            {{-- Preview total --}}
            <div class="card shadow mt-3">
                <div class="card-header bg-light"><h6 class="m-0 fw-bold">Kalkulasi Otomatis</h6></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Total Barang</span>
                        <span id="previewBarang" class="fw-semibold">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Total Jasa</span>
                        <span id="previewJasa" class="fw-semibold">Rp 0</span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">PPh 2% (dari Jasa)</span>
                        <span id="previewPph" class="text-danger fw-semibold">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total Bersih</span>
                        <span id="previewTotal" class="fw-bold text-primary">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form utama --}}
        <div class="col-lg-9 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white"><h6 class="m-0 fw-bold"><i class="fas fa-file-alt me-2"></i>Form DPB</h6></div>
                <div class="card-body">
                    <form id="formDpb" action="{{ route('finance.create-dpb', $maintenance) }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nomor DPB <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_dpb" class="form-control" required value="{{ $nomorDpb }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tanggal DPB <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_dpb" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Bengkel</label>
                                <input type="text" name="nama_bengkel" class="form-control" value="{{ $maintenance->bengkel ?? '' }}" placeholder="Nama bengkel/vendor">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Untuk (Keterangan)</label>
                            <input type="text" name="untuk_keterangan" class="form-control" placeholder="Contoh: Sub Unit Secang / Motor AA 5791 HT">
                        </div>

                        {{-- ===== TABEL BARANG ===== --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-semibold mb-0"><i class="fas fa-box me-1 text-primary"></i>Rincian Barang</label>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="tambahBarang">
                                    <i class="fas fa-plus me-1"></i> Tambah Barang
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="tabelBarang">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Nama Item</th>
                                            <th style="width:80px">Vol</th>
                                            <th style="width:80px">Satuan</th>
                                            <th style="width:150px">Harga Satuan</th>
                                            <th style="width:150px">Jumlah</th>
                                            <th style="width:40px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="rowsBarang">
                                        <tr class="item-row" data-jenis="barang">
                                            <td><input type="text" name="item_nama[]" class="form-control form-control-sm" placeholder="Nama item"></td>
                                            <td><input type="number" name="item_vol[]" class="form-control form-control-sm item-vol" value="1" min="0"></td>
                                            <td><input type="text" name="item_satuan[]" class="form-control form-control-sm" placeholder="bh/ltr/ls"></td>
                                            <td><input type="number" name="item_harga[]" class="form-control form-control-sm item-harga" placeholder="0" min="0"></td>
                                            <td><input type="text" class="form-control form-control-sm item-jumlah bg-light" readonly></td>
                                            <td><button type="button" class="btn btn-sm btn-outline-danger hapus-row"><i class="fas fa-times"></i></button></td>
                                            <input type="hidden" name="item_jenis[]" value="barang">
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-light">
                                            <td colspan="4" class="text-end fw-bold">Total Barang</td>
                                            <td colspan="2"><strong id="totalBarangText">Rp 0</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- ===== TABEL JASA ===== --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-semibold mb-0"><i class="fas fa-wrench me-1 text-warning"></i>Rincian Jasa <span class="badge bg-warning text-dark ms-1">PPh 2% otomatis</span></label>
                                <button type="button" class="btn btn-sm btn-outline-warning" id="tambahJasa">
                                    <i class="fas fa-plus me-1"></i> Tambah Jasa
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="tabelJasa">
                                    <thead class="table-warning">
                                        <tr>
                                            <th>Nama Jasa/Servis</th>
                                            <th style="width:80px">Vol</th>
                                            <th style="width:80px">Satuan</th>
                                            <th style="width:150px">Harga Satuan</th>
                                            <th style="width:150px">Jumlah</th>
                                            <th style="width:40px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="rowsJasa">
                                        {{-- kosong awalnya, user bisa tambah --}}
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-light">
                                            <td colspan="4" class="text-end fw-bold">Total Jasa</td>
                                            <td colspan="2"><strong id="totalJasaText">Rp 0</strong></td>
                                        </tr>
                                        <tr class="table-danger bg-opacity-25">
                                            <td colspan="4" class="text-end fw-bold text-danger">PPh 2%</td>
                                            <td colspan="2"><strong id="pphText" class="text-danger">Rp 0</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="alert alert-info py-2">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">TOTAL BIAYA BERSIH</span>
                                <span class="fw-bold fs-5" id="totalBersihText">Rp 0</span>
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan & Buat DPB
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function formatRp(num) {
    return 'Rp ' + Math.round(num).toLocaleString('id-ID');
}

function hitungSemua() {
    let totalBarang = 0;
    let totalJasa   = 0;

    // Hitung barang
    document.querySelectorAll('#rowsBarang .item-row').forEach(row => {
        const vol    = parseFloat(row.querySelector('.item-vol').value) || 0;
        const harga  = parseFloat(row.querySelector('.item-harga').value) || 0;
        const jumlah = vol * harga;
        row.querySelector('.item-jumlah').value = jumlah ? jumlah.toLocaleString('id-ID') : '';
        totalBarang += jumlah;
    });

    // Hitung jasa
    document.querySelectorAll('#rowsJasa .item-row').forEach(row => {
        const vol    = parseFloat(row.querySelector('.item-vol').value) || 0;
        const harga  = parseFloat(row.querySelector('.item-harga').value) || 0;
        const jumlah = vol * harga;
        row.querySelector('.item-jumlah').value = jumlah ? jumlah.toLocaleString('id-ID') : '';
        totalJasa += jumlah;
    });

    const pph        = Math.round(totalJasa * 0.02);
    const totalBersih = totalBarang + totalJasa - pph;

    document.getElementById('totalBarangText').textContent = formatRp(totalBarang);
    document.getElementById('totalJasaText').textContent   = formatRp(totalJasa);
    document.getElementById('pphText').textContent         = formatRp(pph);
    document.getElementById('totalBersihText').textContent = formatRp(totalBersih);
    // Sidebar
    document.getElementById('previewBarang').textContent = formatRp(totalBarang);
    document.getElementById('previewJasa').textContent   = formatRp(totalJasa);
    document.getElementById('previewPph').textContent    = formatRp(pph);
    document.getElementById('previewTotal').textContent  = formatRp(totalBersih);
}

function buatRowBarang() {
    const tr = document.createElement('tr');
    tr.className = 'item-row';
    tr.dataset.jenis = 'barang';
    tr.innerHTML = `
        <td><input type="text" name="item_nama[]" class="form-control form-control-sm"></td>
        <td><input type="number" name="item_vol[]" class="form-control form-control-sm item-vol" value="1" min="0"></td>
        <td><input type="text" name="item_satuan[]" class="form-control form-control-sm" placeholder="bh/ltr/ls"></td>
        <td><input type="number" name="item_harga[]" class="form-control form-control-sm item-harga" min="0"></td>
        <td><input type="text" class="form-control form-control-sm item-jumlah bg-light" readonly></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger hapus-row"><i class="fas fa-times"></i></button></td>
        <input type="hidden" name="item_jenis[]" value="barang">
    `;
    return tr;
}

function buatRowJasa() {
    const tr = document.createElement('tr');
    tr.className = 'item-row';
    tr.dataset.jenis = 'jasa';
    tr.innerHTML = `
        <td><input type="text" name="item_nama[]" class="form-control form-control-sm"></td>
        <td><input type="number" name="item_vol[]" class="form-control form-control-sm item-vol" value="1" min="0"></td>
        <td><input type="text" name="item_satuan[]" class="form-control form-control-sm" placeholder="ls/jam"></td>
        <td><input type="number" name="item_harga[]" class="form-control form-control-sm item-harga" min="0"></td>
        <td><input type="text" class="form-control form-control-sm item-jumlah bg-light" readonly></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger hapus-row"><i class="fas fa-times"></i></button></td>
        <input type="hidden" name="item_jenis[]" value="jasa">
    `;
    return tr;
}

document.getElementById('tambahBarang').addEventListener('click', () => {
    document.getElementById('rowsBarang').appendChild(buatRowBarang());
});

document.getElementById('tambahJasa').addEventListener('click', () => {
    document.getElementById('rowsJasa').appendChild(buatRowJasa());
});

// Event delegation untuk hitung dan hapus
document.getElementById('formDpb').addEventListener('input', function(e) {
    if (e.target.classList.contains('item-vol') || e.target.classList.contains('item-harga')) {
        hitungSemua();
    }
});

document.getElementById('formDpb').addEventListener('click', function(e) {
    if (e.target.closest('.hapus-row')) {
        const tbody = e.target.closest('tbody');
        const rows  = tbody.querySelectorAll('.item-row');
        if (rows.length > 1 || tbody.id === 'rowsJasa') {
            e.target.closest('.item-row').remove();
            hitungSemua();
        }
    }
});

hitungSemua();
</script>
@endpush
@endsection