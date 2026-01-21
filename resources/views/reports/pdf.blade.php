<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aset Kantor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            margin: 1.5cm;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .summary {
            margin: 20px 0;
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }
        
        .summary-item {
            display: inline-block;
            width: 48%;
            margin-bottom: 10px;
        }
        
        .summary-item strong {
            display: block;
            color: #333;
            font-size: 11pt;
        }
        
        .summary-item span {
            display: block;
            color: #666;
            font-size: 9pt;
        }
        
        h3 {
            margin-top: 25px;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 2px solid #4e73df;
            padding-bottom: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 9pt;
        }
        
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        table th {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
        }
        
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8pt;
            color: #666;
        }
        
        .page-break {
            page-break-after: always;
        }
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
            <strong>Total Nilai: Rp {{ number_format($totalNilai, 0, ',', '.') }}</strong>
            <span>Nilai keseluruhan aset</span>
        </div>
    </div>

    <div style="clear: both;"></div>

    <!-- Distribusi Per Kategori -->
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
            @php $totalAssets = $byCategory->sum('jumlah'); @endphp
            @foreach($byCategory as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->jumlah }} unit</td>
                <td>{{ number_format(($item->jumlah / $totalAssets) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Distribusi Per Kondisi -->
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
            @foreach($byCondition as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kondisi }}</td>
                <td>{{ $item->jumlah }} unit</td>
                <td>{{ number_format(($item->jumlah / $totalAssets) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

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