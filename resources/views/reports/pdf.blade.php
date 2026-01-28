<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aset Kantor</title>
    <style>
        /* ... styles tetap sama ... */
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Aset Kantor</h1>
        <p>Sistem Manajemen Aset</p>
        <p>Tanggal Cetak: {{ now()->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }}</p>
    </div>

    <!-- Ringkasan -->
    <div class="summary">
        <div class="summary-item">
            <strong>Total Aset: {{ $assets->count() }} unit</strong>
            <span>Jumlah seluruh aset yang tercatat</span>
        </div>
        <div class="summary-item" style="float: right;">
            <strong>Total Nilai: Rp {{ number_format($assets->sum('nilai_perolehan'), 0, ',', '.') }}</strong>
            <span>Nilai keseluruhan aset</span>
        </div>
    </div>

    <div style="clear: both;"></div>

    <!-- Distribusi Per Kategori -->
    @if(isset($byCategory) && $byCategory->count() > 0)
    <h3>Distribusi Aset Per Kategori</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $totalCategory = $byCategory->sum('jumlah'); @endphp
            @foreach($byCategory as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->jumlah }} unit</td>
                <td>{{ $totalCategory > 0 ? number_format(($item->jumlah / $totalCategory) * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Distribusi Per Kondisi -->
    @if(isset($byCondition) && $byCondition->count() > 0)
    <h3>Distribusi Aset Per Kondisi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kondisi</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $totalCondition = $byCondition->sum('jumlah'); @endphp
            @foreach($byCondition as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kondisi }}</td>
                <td>{{ $item->jumlah }} unit</td>
                <td>{{ $totalCondition > 0 ? number_format(($item->jumlah / $totalCondition) * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="page-break"></div>

    <!-- Daftar Aset Lengkap -->
    <h3>Daftar Aset Lengkap</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Kondisi</th>
                <th>Pemegang</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $index => $asset)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $asset->kode_aset }}</td>
                <td>{{ $asset->nama_aset }}</td>
                <td>{{ $asset->kategori }}</td>
                <td>{{ $asset->kondisi }}</td>
                <td>{{ $asset->pemegang_saat_ini ?? '-' }}</td>
                <td>Rp {{ number_format($asset->nilai_perolehan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Sistem Manajemen Aset Kantor</strong></p>
        <p>Dokumen ini dibuat secara otomatis oleh sistem</p>
    </div>
</body>
</html>