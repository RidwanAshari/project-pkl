<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Serah Terima Aset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.6;
            margin: 2cm;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 14pt;
        }
        
        .nomor {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .content {
            text-align: justify;
            margin-bottom: 20px;
        }
        
        .content p {
            margin: 10px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table th, table td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }
        
        table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .signatures {
            margin-top: 50px;
        }
        
        .signature-box {
            display: inline-block;
            width: 45%;
            text-align: center;
        }
        
        .signature-box.left {
            float: left;
        }
        
        .signature-box.right {
            float: right;
        }
        
        .signature-line {
            margin-top: 80px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        
        .footer {
            margin-top: 100px;
            font-size: 10pt;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Berita Acara Serah Terima</h1>
        <h2>Aset Kantor</h2>
    </div>

    <div class="nomor">
        Nomor: {{ $history->nomor_ba }}
    </div>

    <div class="content">
        <p>Pada hari ini, <strong>{{ $history->tanggal_serah_terima->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong>, telah dilakukan serah terima aset dengan rincian sebagai berikut:</p>
    </div>

    <table>
        <tr>
            <th width="30%">Kode Aset</th>
            <td>{{ $asset->kode_aset }}</td>
        </tr>
        <tr>
            <th>Nama Aset</th>
            <td>{{ $asset->nama_aset }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $asset->kategori }}</td>
        </tr>
        <tr>
            <th>Merk/Tipe</th>
            <td>{{ $asset->merk }} {{ $asset->tipe }}</td>
        </tr>
        <tr>
            <th>Tahun Perolehan</th>
            <td>{{ $asset->tahun_perolehan }}</td>
        </tr>
        <tr>
            <th>Nilai Perolehan</th>
            <td>Rp {{ number_format($asset->nilai_perolehan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Kondisi</th>
            <td>{{ $asset->kondisi }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>{{ $asset->lokasi }}</td>
        </tr>
    </table>

    <div class="content">
        <p><strong>Diserahkan dari:</strong> {{ $history->dari_pemegang ?? 'Bagian Pengadaan' }}</p>
        <p><strong>Diterima oleh:</strong> {{ $history->ke_pemegang }}</p>
        
        @if($history->keterangan)
        <p><strong>Keterangan:</strong> {{ $history->keterangan }}</p>
        @endif
    </div>

    <div class="content">
        <p>Dengan ditandatanganinya berita acara ini, maka:</p>
        <ol>
            <li>Pihak penerima menyatakan telah menerima aset dalam kondisi seperti tercantum di atas.</li>
            <li>Pihak penerima bertanggung jawab penuh atas aset yang diterima.</li>
            <li>Serah terima aset ini dilakukan dengan sukarela tanpa paksaan dari pihak manapun.</li>
        </ol>
    </div>

    <div class="signatures">
        <div class="signature-box left">
            <p>Yang Menyerahkan,</p>
            <div class="signature-line">
                <strong>{{ $history->dari_pemegang ?? 'Bagian Pengadaan' }}</strong>
            </div>
        </div>

        <div class="signature-box right">
            <p>Yang Menerima,</p>
            <div class="signature-line">
                <strong>{{ $history->ke_pemegang }}</strong>
            </div>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="footer">
        <p>Dokumen ini dibuat secara elektronik melalui Sistem Manajemen Aset Kantor</p>
        <p>Tanggal Cetak: {{ now()->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }}</p>
    </div>
</body>
</html>