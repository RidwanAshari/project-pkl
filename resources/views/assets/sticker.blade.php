<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Stiker - {{ $asset->kode_aset }}</title>
    <style>
        @page { size: 10cm 5cm; margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: white; }

        .sticker {
            width: 10cm; height: 5cm;
            border: 2px solid #222;
            display: table;
            table-layout: fixed;
        }
        .qr-col {
            display: table-cell;
            width: 4cm;
            vertical-align: middle;
            text-align: center;
            border-right: 1px solid #aaa;
            padding: 4px;
        }
        .qr-col img { width: 3.2cm; height: 3.2cm; display: block; margin: 0 auto; }
        .qr-col p { font-size: 5.5pt; color: #666; margin-top: 2px; }
        .info-col {
            display: table-cell;
            vertical-align: top;
            padding: 6px 8px;
        }
        .header {
            text-align: center;
            border-bottom: 1.5px solid #333;
            padding-bottom: 4px;
            margin-bottom: 5px;
        }
        .header h3 { font-size: 11pt; font-weight: bold; letter-spacing: 1px; }
        .header p  { font-size: 7pt; color: #555; }
        .field { margin-bottom: 3px; }
        .label { font-size: 7pt; color: #777; }
        .value { font-size: 10pt; font-weight: bold; line-height: 1.2; }
        .footer { font-size: 6.5pt; color: #888; margin-top: 4px; text-align: center; }

        .no-print { margin: 16px; }
        @media print { .no-print { display: none !important; } body { margin: 0; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="padding:8px 20px;background:#4e73df;color:white;border:none;border-radius:5px;cursor:pointer;font-size:13px;">
            🖨️ Cetak Stiker
        </button>
        <a href="{{ url()->previous() }}" style="margin-left:8px;padding:8px 16px;background:#6c757d;color:white;text-decoration:none;border-radius:5px;font-size:13px;">← Kembali</a>
    </div>

    <div class="sticker">
        {{-- Kolom QR Code --}}
        <div class="qr-col">
            @if($asset->qr_code)
                {{-- QR code mengarah ke URL detail aset --}}
                @php
                    $qrUrl = $asset->kategori === 'Kendaraan'
                        ? route('vehicles.show', $asset)
                        : route('assets.show', $asset);
                    // Generate QR baru yang mengarah ke URL
                    $qrSvg = \QrCode::format('svg')->size(120)->errorCorrection('H')->generate($qrUrl);
                @endphp
                <img src="data:image/svg+xml;base64,{{ base64_encode($qrSvg) }}" alt="QR Code">
            @else
                <div style="width:3.2cm;height:3.2cm;border:1px solid #ccc;display:flex;align-items:center;justify-content:center;font-size:7pt;color:#999;">No QR</div>
            @endif
            <p>Scan untuk detail</p>
        </div>

        {{-- Kolom Info --}}
        <div class="info-col">
            <div class="header">
                <h3>ASET KANTOR</h3>
                <p>Perumda Air Minum Tirta Gemilang</p>
            </div>
            <div class="field">
                <div class="label">Kode Aset:</div>
                <div class="value">{{ $asset->kode_aset }}</div>
            </div>
            <div class="field">
                <div class="label">Nama Aset:</div>
                <div class="value" style="font-size:9pt;">{{ Str::limit($asset->nama_aset, 28) }}</div>
            </div>
            <div class="field">
                <div class="label">Kategori:</div>
                <div class="value" style="font-size:9pt;">{{ $asset->kategori }}</div>
            </div>
            <div class="footer">Scan QR Code untuk info lengkap</div>
        </div>
    </div>
</body>
</html>