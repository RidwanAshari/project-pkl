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
            'foto' => 'nullable|image|max:2048'
        ]);

        // Upload foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('assets', 'public');
        }

        // Generate QR Code
        $qrCode = QrCode::format('png')->size(200)->generate($validated['kode_aset']);
        $qrPath = 'qrcodes/' . $validated['kode_aset'] . '.png';
        Storage::disk('public')->put($qrPath, $qrCode);
        $validated['qr_code'] = $qrPath;

        $asset = Asset::create($validated);

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
}