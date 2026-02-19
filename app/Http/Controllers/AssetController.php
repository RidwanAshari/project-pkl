<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::query();

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_aset', 'like', "%{$search}%")
                  ->orWhere('nama_aset', 'like', "%{$search}%")
                  ->orWhere('pemegang_saat_ini', 'like', "%{$search}%");
            });
        }

        $assets = $query->latest()->paginate(10);

        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_aset' => 'required|unique:assets',
            'nama_aset' => 'required',
            'kategori' => 'required|in:Bangunan,Tanah,Kendaraan,Peralatan,Investasi',
            'merk' => 'nullable',
            'tipe' => 'nullable',
            'tahun_perolehan' => 'required|integer',
            'nilai_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi' => 'required',
            'pemegang_saat_ini' => 'nullable',
            'keterangan' => 'nullable',
            'foto' => 'nullable|image|max:2048',
            
            // Vehicle details (jika kategori kendaraan)
            'nama_pemilik' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'nomor_plat' => 'nullable|string',
            'model' => 'nullable|string',
            'tahun_pembuatan' => 'nullable|integer',
            'isi_silinder' => 'nullable|string',
            'nomor_rangka' => 'nullable|string',
            'nomor_mesin' => 'nullable|string',
            'warna' => 'nullable|string',
            'bahan_bakar' => 'nullable|string',
            'warna_tnkb' => 'nullable|string',
            'tahun_registrasi' => 'nullable|integer',
            'nomor_bpkb' => 'nullable|string',
            'tanggal_berlaku' => 'nullable|date',
            'bulan_berlaku' => 'nullable|string',
            'tahun_berlaku' => 'nullable|string',
            'berat' => 'nullable|numeric',
            'sumbu' => 'nullable|integer',
            'penumpang' => 'nullable|integer',
        ]);

        // Upload foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('assets', 'public');
        }

        // Generate QR Code pakai SVG (no extension needed)
       try {
    $qrCode = QrCode::format('svg')
        ->size(200)
        ->errorCorrection('H')
        ->generate($validated['kode_aset']);

    $qrPath = 'qrcodes/' . $validated['kode_aset'] . '.svg';

    Storage::disk('public')->put($qrPath, $qrCode);

    $validated['qr_code'] = $qrPath;

} catch (\Exception $e) {
    $validated['qr_code'] = null;
}


        // Buat aset
        $assetData = collect($validated)->only([
            'kode_aset', 'nama_aset', 'kategori', 'merk', 'tipe', 
            'tahun_perolehan', 'nilai_perolehan', 'kondisi', 'lokasi', 
            'pemegang_saat_ini', 'keterangan', 'foto', 'qr_code'
        ])->toArray();
        
        $asset = Asset::create($assetData);

        // Jika kategori kendaraan, simpan detail kendaraan
        if ($validated['kategori'] === 'Kendaraan') {
            $vehicleData = collect($validated)->only([
                'nama_pemilik', 'jabatan', 'alamat', 'nomor_plat', 'model', 
                'tahun_pembuatan', 'isi_silinder', 'nomor_rangka', 'nomor_mesin', 
                'warna', 'bahan_bakar', 'warna_tnkb', 'tahun_registrasi', 
                'nomor_bpkb', 'tanggal_berlaku', 'bulan_berlaku', 'tahun_berlaku', 
                'berat', 'sumbu', 'penumpang'
            ])->filter()->toArray();
            
            if (!empty($vehicleData)) {
                $vehicleData['asset_id'] = $asset->id;
                \App\Models\VehicleDetail::create($vehicleData);
            }
        }

        // Buat histori awal jika ada pemegang
        if ($request->filled('pemegang_saat_ini')) {
            AssetHistory::create([
                'asset_id' => $asset->id,
                'dari_pemegang' => null,
                'ke_pemegang' => $request->pemegang_saat_ini,
                'tanggal_serah_terima' => now(),
                'nomor_ba' => AssetHistory::generateNomorBA(),
                'keterangan' => 'Penerimaan awal aset'
            ]);
        }

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan!');
    }

    public function show(Asset $asset)
    {
        $asset->load('histories');
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'kode_aset' => 'required|unique:assets,kode_aset,' . $asset->id,
            'nama_aset' => 'required',
            'kategori' => 'required|in:Bangunan,Tanah,Kendaraan,Peralatan,Investasi',
            'merk' => 'nullable',
            'tipe' => 'nullable',
            'tahun_perolehan' => 'required|integer',
            'nilai_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi' => 'required',
            'pemegang_saat_ini' => 'nullable',
            'keterangan' => 'nullable',
            'foto' => 'nullable|image|max:2048'
        ]);

        // Upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($asset->foto) {
                Storage::disk('public')->delete($asset->foto);
            }
            $validated['foto'] = $request->file('foto')->store('assets', 'public');
        }

        $asset->update($validated);

        return redirect()->route('assets.show', $asset)->with('success', 'Aset berhasil diupdate!');
    }

    public function destroy(Asset $asset)
    {
        // Hapus foto
        if ($asset->foto) {
            Storage::disk('public')->delete($asset->foto);
        }

        // Hapus QR Code
        if ($asset->qr_code) {
            Storage::disk('public')->delete($asset->qr_code);
        }

        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus!');
    }

    // Transfer aset (ganti pemegang)
    public function transfer(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'ke_pemegang' => 'required',
            'tanggal_serah_terima' => 'required|date',
            'keterangan' => 'nullable'
        ]);

        // Buat histori baru
        $history = AssetHistory::create([
            'asset_id' => $asset->id,
            'dari_pemegang' => $asset->pemegang_saat_ini,
            'ke_pemegang' => $validated['ke_pemegang'],
            'tanggal_serah_terima' => $validated['tanggal_serah_terima'],
            'nomor_ba' => AssetHistory::generateNomorBA(),
            'keterangan' => $validated['keterangan']
        ]);

        // Update pemegang saat ini
        $asset->update([
            'pemegang_saat_ini' => $validated['ke_pemegang']
        ]);

        return redirect()->route('assets.show', $asset)->with('success', 'Transfer aset berhasil! Nomor BA: ' . $history->nomor_ba);
    }

    // Print stiker
    public function printSticker(Asset $asset)
    {
        return view('assets.sticker', compact('asset'));
    }

    // QR Code Redirect - untuk scan barcode
    public function qrRedirect($kode_aset)
    {
        $asset = Asset::where('kode_aset', $kode_aset)->firstOrFail();
        
        // Jika kendaraan, redirect ke detail kendaraan
        if ($asset->kategori === 'Kendaraan') {
            return redirect()->route('vehicles.show', $asset);
        }
        
        // Selain kendaraan, redirect ke detail aset biasa
        return redirect()->route('assets.show', $asset);
    }

    // Download Berita Acara PDF
    public function downloadBA(AssetHistory $history)
    {
        $asset = $history->asset;
        
        $pdf = \PDF::loadView('assets.berita-acara', compact('asset', 'history'));
        
        // Replace karakter / dengan - untuk nama file
        $filename = 'BA_' . str_replace('/', '-', $history->nomor_ba) . '.pdf';
        
        return $pdf->download($filename);
    }
}