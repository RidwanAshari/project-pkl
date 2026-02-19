<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stiker Aset - {{ $asset->kode_aset }}</title>
    <style>
        @page {
            size: 10cm 5cm;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 0.5cm;
        }

        .sticker {
            width: 9cm;
            height: 4cm;
            border: 2px solid #333;
            padding: 0.3cm;
            display: flex;
            gap: 0.3cm;
        }

        .qr-section {
            width: 3cm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .qr-section img {
            width: 2.5cm;
            height: 2.5cm;
        }

        .info-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 0.2cm;
            margin-bottom: 0.2cm;
        }

        .header h3 {
            font-size: 14pt;
            margin: 0;
        }

        .header p {
            font-size: 8pt;
            margin: 0;
        }

        .content {
            flex: 1;
        }

        .field {
            margin-bottom: 0.15cm;
        }

        .field .label {
            font-size: 8pt;
            color: #666;
        }

        .field .value {
            font-size: 11pt;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 7pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 0.1cm;
        }

        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .print-button:hover {
            background: #224abe;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">
        🖨️ Cetak Stiker
    </button>

    <div class="sticker">
        <div class="qr-section">
            @if($asset->qr_code)
                <img src="{{ asset('storage/' . $asset->qr_code) }}" alt="QR Code">
            @else
                <div style="width: 2.5cm; height: 2.5cm; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; font-size: 8pt;">
                    No QR
                </div>
            @endif
        </div>

        <div class="info-section">
            <div class="header">
                <h3>ASET KANTOR</h3>
                <p>Sistem Manajemen Aset</p>
            </div>

            <div class="content">
                <div class="field">
                    <div class="label">Kode Aset:</div>
                    <div class="value">{{ $asset->kode_aset }}</div>
                </div>

                <div class="field">
                    <div class="label">Nama Aset:</div>
                    <div class="value">{{ Str::limit($asset->nama_aset, 30) }}</div>
                </div>

                <div class="field">
                    <div class="label">Kategori:</div>
                    <div class="value">{{ $asset->kategori }}</div>
                </div>

                <div class="field">
                    <div class="label">Tahun:</div>
                    <div class="value">{{ $asset->tahun_perolehan }}</div>
                </div>
            </div>

            <div class="footer">
                Scan QR Code untuk info lengkap
            </div>
        </div>
    </div>

    <script>
        // Auto print saat halaman load (opsional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>