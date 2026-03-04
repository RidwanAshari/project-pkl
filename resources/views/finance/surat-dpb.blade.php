<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DPB - {{ $dpb->nomor_dpb }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11pt; color: #000; padding: 20px 30px; }

        .judul { text-align: center; margin: 10px 0 8px; }
        .judul div { line-height: 1.5; }
        .teks-judul { font-size: 13pt; font-weight: bold; text-transform: uppercase; }
        .sub-judul  { font-size: 11pt; font-weight: bold; text-transform: uppercase; }
        .nomor-line { font-size: 10.5pt; margin-top: 4px; text-align: left; padding-left: 8px; }

        table.dpb-table { width: 100%; border-collapse: collapse; margin: 8px 0; font-size: 10.5pt; }
        table.dpb-table th, table.dpb-table td { border: 1px solid #000; padding: 3px 7px; vertical-align: top; }
        table.dpb-table thead th { text-align: center; font-weight: bold; background: none; }
        table.dpb-table tfoot td { padding: 4px 7px; border: 1px solid #000; }
        .col-no     { width: 34px; text-align: center; }
        .col-vol    { width: 65px; text-align: center; }
        .col-harga  { width: 115px; text-align: right; }
        .col-jumlah { width: 115px; text-align: right; }
        .col-ket    { width: 130px; }
        td[rowspan] { border-bottom: 1px solid #000 !important; }
                .row-bengkel td { font-weight: normal; }
        .row-plat td { font-size: 10pt; }
        .row-label-kategori td { font-style: italic; font-size: 10pt; padding: 8px 7px 2px 7px; background: none; }
        .row-pph td { font-style: italic; font-size: 9.5pt; color: #333; }
        .row-pph .pph-ket { font-size: 9pt; color: #555; }
        .row-total td { font-weight: normal; }
        .row-total .label-jumlah { font-weight: bold; }

        .ttd-section { margin-top: 16px; }
        .ttd-table { width: 100%; border-collapse: collapse; }
        .ttd-table td { text-align: center; vertical-align: top; width: 33.3%; padding: 0 8px; font-size: 10.5pt; }
        .ttd-space { height: 62px; }
        .ttd-nama { font-weight: bold; }
        .ttd-nipp { font-size: 9.5pt; }
        @media print {
            body { padding: 8px 18px; }
            @page { size: A4; margin: 12mm 15mm; }
        }
    </style>
</head>
<body>

@php
    $items       = $dpb->uraian_items ?? [];
    $barangItems = collect($items)->where('jenis', 'barang')->values();
    $jasaItems   = collect($items)->where('jenis', 'jasa')->values();
    $totalBarang = $barangItems->sum('jumlah');
    $totalJasa   = $jasaItems->sum('jumlah');
    $totalBersih = $totalBarang + $totalJasa; // PPh tidak dikurangi, cuma info
    $pph         = round($totalJasa * 0.02);
    $asset       = $maintenance->asset ?? null;
    $nomorPlat   = $asset?->vehicleDetail?->nomor_plat ?? '-';
    $tglFormatted = \Carbon\Carbon::parse($dpb->tanggal_dpb)->locale('id')->translatedFormat('F Y');
    $pembuatUser  = \App\Models\User::find($dpb->dibuat_oleh);
    // Rowspan KET: bengkel + plat + barang + label jasa + jasa items + pph row + total
    $ketRowspan = 1 // bengkel
                + 1 // plat
                + ($barangItems->count() > 0 ? 1 + $barangItems->count() : 0) // label + items barang
                + ($jasaItems->count() > 0 ? 1 + $jasaItems->count() + 1 : 0) // label + items jasa + pph
                + 1; // total
@endphp

{{-- KOP --}}
<div style="margin-bottom:8px;">
    <div style="font-size:12pt;font-weight:bold;text-transform:uppercase;">Perumda Air Minum Tirta Gemilang</div>
    <div style="font-size:12pt;font-weight:bold;text-transform:uppercase;">Kabupaten Magelang</div>
</div>


{{-- JUDUL --}}
<div class="judul">
    <div class="teks-judul">Daftar Permintaan Biaya (DPB)</div>
    <div class="sub-judul">Biaya Pemeliharaan Kendaraan</div>
    <div class="sub-judul">Perumda Air Minum Tirta Gemilang Kabupaten Magelang</div>
</div>
<div style="text-align:center; font-size:10.5pt; margin: 4px 0 8px;"><strong>Nomor : &nbsp; {{ $dpb->nomor_dpb }}</strong></div>

{{-- TABEL --}}
<table class="dpb-table">
    <thead>
        <tr>
            <th class="col-no">NO</th>
            <th>URAIAN</th>
            <th class="col-vol">VOL</th>
            <th class="col-harga">HARGA SATUAN</th>
            <th class="col-jumlah">JUMLAH</th>
            <th class="col-ket">KET.</th>
        </tr>
    </thead>
    <tbody>
        {{-- Nama Bengkel --}}
        <tr class="row-bengkel">
            <td class="col-no"></td>
            <td colspan="4" style="border-right:1px solid #000;">{{ strtoupper($dpb->nama_bengkel ?? $maintenance->bengkel ?? '-') }}</td>
            <td rowspan="{{ $ketRowspan }}" style="vertical-align:top;">
                @if($dpb->untuk_keterangan)
                    Untuk :<br>{{ $dpb->untuk_keterangan }}
                @endif
            </td>
        </tr>

        {{-- Nomor urut + Nomor Plat --}}
        <tr class="row-plat">
            <td class="col-no">1</td>
            <td>{{ $nomorPlat }}</td>
            <td></td><td></td><td></td>
        </tr>

        {{-- ===== SECTION PERBAIKAN (BARANG) ===== --}}
        @if($barangItems->count())
        <tr class="row-label-kategori">
            <td class="col-no"></td>
            <td colspan="4" style="border-right:1px solid #000;">Perbaikan</td>
        </tr>
        @foreach($barangItems as $idx => $item)
        <tr>
            <td class="col-no"></td>
            <td>{{ $item['nama'] }}</td>
            <td class="col-vol">{{ $item['vol'] }} {{ $item['satuan'] }}</td>
            <td class="col-harga">{{ number_format($item['harga'], 0, ',', '.') }}</td>
            <td class="col-jumlah">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
        </tr>
        @endforeach
        @endif

        {{-- ===== SECTION JASA ===== --}}
        @if($jasaItems->count())
        <tr class="row-label-kategori">
            <td class="col-no"></td>
            <td colspan="4" style="border-right:1px solid #000;">Jasa</td>
        </tr>
        @foreach($jasaItems as $idx => $item)
        <tr>
            <td class="col-no"></td>
            <td>{{ $item['nama'] }}</td>
            <td class="col-vol">{{ $item['vol'] }} {{ $item['satuan'] }}</td>
            <td class="col-harga">{{ number_format($item['harga'], 0, ',', '.') }}</td>
            <td class="col-jumlah">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
        </tr>
        @endforeach

        {{-- PPh — info saja, TIDAK masuk kolom jumlah, TIDAK mempengaruhi total --}}
        <tr class="row-pph">
            <td class="col-no"></td>
            <td colspan="4" style="border-right:1px solid #000;">
                <span><em>PPh ; = 2% × ({{ $jasaItems->pluck('nama')->implode(' + ') }})</em></span><br>
                <span class="pph-ket">= 2% × {{ number_format($totalJasa, 0, ',', '.') }} = {{ number_format($pph, 0, ',', '.') }}</span>
            </td>
        </tr>
        @endif


        <tr class="row-total">
            <td class="col-no"></td>
            <td><strong>Jumlah ......</strong></td>
            <td></td>
            <td></td>
            <td class="col-jumlah">{{ number_format($totalBersih, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

{{-- Tanggal --}}
<div style="text-align:right; margin: 10px 0 18px; font-size:10.5pt;">
    Kota Mungkid, {{ $tglFormatted }}
</div>

{{-- TTD: Menyetujui | Diperiksa | Dibuat oleh (sesuai contoh fisik) --}}
<div class="ttd-section">
    <table class="ttd-table">
        <tr>
            <td>
                <div>Menyetujui,</div>
                <div>Direktur Utama,</div>
                <div class="ttd-space"></div>
                <div class="ttd-nama">( AGUS TRI SUHARYONO SE.MM )</div>
                <div class="ttd-nipp">&nbsp;</div>
            </td>
            <td>
                <div>Diperiksa oleh :</div>
                <div>Ka.bag. Umum &amp; Administrasi</div>
                <div class="ttd-space"></div>
                <div class="ttd-nama">( FAJAR KURNIAWAN, SE )</div>
                <div class="ttd-nipp">NIPP. 1293.0903.78</div>
            </td>
            <td>
                <div>Dibuat oleh :</div>
                <div>Ka.Sub.bag. Umum &amp; PDE</div>
                <div class="ttd-space"></div>
                <div class="ttd-nama">( EKO PRASETYO, S.T )</div>
                <div class="ttd-nipp">NIPP. 1283.0803.76</div>
            </td>
        </tr>
    </table>
</div>

<script>window.onload = function(){ window.print(); }</script>
</body>
</html>