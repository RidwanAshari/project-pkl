<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar Service Kendaraan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            margin: 2cm;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 10pt;
        }
        
        .nomor {
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
        }
        
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table th, table td {
            padding: 8px;
            text-align: left;
        }
        
        table th {
            width: 30%;
        }
        
        .signatures {
            margin-top: 50px;
        }
        
        .signature-box {
            display: inline-block;
            width: 45%;
            text-align: center;
        }
        
        .signature-box.right {
            float: right;
        }
        
        .signature-line {
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        
        .footer {
            margin-top: 50px;
            font-size: 9pt;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Surat Pengantar</h1>
        <p>Service/Perbaikan Kendaraan Dinas</p>
    </div>

    <div class="nomor">
        Nomor: SP/{{ date('m') }}/{{ date('Y') }}/{{ str_pad($maintenance->id, 4, '0', STR_PAD_LEFT) }}
    </div>

    <div class="content">
        <p>Kepada Yth,<br>
        <strong>{{ $maintenance->bengkel ?? 'Bengkel Tujuan' }}</strong><br>
        Di Tempat</p>

        <p>Dengan hormat,</p>

        <p>Bersama ini kami mengirimkan kendaraan dinas untuk dilakukan <strong>{{ $maintenance->jenis_servis }}</strong> dengan rincian sebagai berikut:</p>
    </div>

    <table>
        <tr>
            <th>Kode Aset</th>
            <td>: {{ $asset->kode_aset }}</td>
        </tr>
        <tr>
            <th>Jenis Kendaraan</th>
            <td>: {{ $asset->nama_aset }}</td>
        </tr>
        <tr>
            <th>Merk/Type</th>
            <td>: {{ $asset->merk }} {{ $asset->tipe }}</td>
        </tr>
        @if($vehicleDetail && $vehicleDetail->nomor_plat)
        <tr>
            <th>Nomor Polisi</th>
            <td>: {{ $vehicleDetail->nomor_plat }}</td>
        </tr>
        @endif
        @if($vehicleDetail && $vehicleDetail->nomor_rangka)
        <tr>
            <th>Nomor Rangka</th>
            <td>: {{ $vehicleDetail->nomor_rangka }}</td>
        </tr>
        @endif
        @if($vehicleDetail && $vehicleDetail->nomor_mesin)
        <tr>
            <th>Nomor Mesin</th>
            <td>: {{ $vehicleDetail->nomor_mesin }}</td>
        </tr>
        @endif
        @if($vehicleDetail && $vehicleDetail->warna)
        <tr>
            <th>Warna</th>
            <td>: {{ $vehicleDetail->warna }}</td>
        </tr>
        @endif
        <tr>
            <th>Jenis Pekerjaan</th>
            <td>: {{ $maintenance->jenis_servis }}</td>
        </tr>
        @if($maintenance->keterangan)
        <tr>
            <th>Keterangan</th>
            <td>: {{ $maintenance->keterangan }}</td>
        </tr>
        @endif
        <tr>
            <th>Tanggal</th>
            <td>: {{ $maintenance->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
        </tr>
    </table>

    <div class="content">
        <p>Demikian surat pengantar ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
    </div>

    <div class="signatures">
        <div class="signature-box right">
            <p>{{ $maintenance->tanggal->locale('id')->isoFormat('D MMMM Y') }}</p>
            <p>Hormat kami,</p>
            <div class="signature-line">
                <strong>Kepala Bagian Umum</strong>
            </div>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="footer">
        <p>Catatan: Surat ini dibuat secara elektronik dan sah tanpa tanda tangan basah</p>
        <p>Dicetak: {{ now()->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }}</p>
    </div>
</body>
</html>