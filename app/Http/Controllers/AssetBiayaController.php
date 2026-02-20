<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetBiayaController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::where('tipe_dashboard', 'biaya');

        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('kondisi'))  $query->where('kondisi', $request->kondisi);
        if ($request->filled('pemegang')) $query->where('pemegang_saat_ini', $request->pemegang);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_aset', 'like', "%{$search}%")
                  ->orWhere('nama_aset', 'like', "%{$search}%");
            });
        }

        $assets = $query->latest()->paginate(10);
        $users  = User::orderBy('name')->get();
        return view('assets.index-biaya', compact('assets', 'users'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('assets.create-biaya', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_aset'        => 'required|unique:assets',
            'nama_aset'        => 'required',
            'kategori'         => 'required|in:Bangunan,Tanah,Kendaraan,Peralatan,Inventaris Barang dan Perabot Kantor',
            'merk'             => 'nullable',
            'tipe'             => 'nullable',
            'tahun_perolehan'  => 'required|integer',
            'nilai_perolehan'  => 'required|numeric',
            'kondisi'          => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi'           => 'required',
            'pemegang_saat_ini'=> 'nullable',
            'keterangan'       => 'nullable',
            'foto'             => 'nullable|image|max:2048',
            'nama_pemilik'     => 'nullable|string',
            'jabatan'          => 'nullable|string',
            'alamat'           => 'nullable|string',
            'nomor_plat'       => 'nullable|string',
            'model'            => 'nullable|string',
            'tahun_pembuatan'  => 'nullable|integer',
            'isi_silinder'     => 'nullable|string',
            'nomor_rangka'     => 'nullable|string',
            'nomor_mesin'      => 'nullable|string',
            'warna'            => 'nullable|string',
            'bahan_bakar'      => 'nullable|string',
            'nomor_bpkb'       => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('assets', 'public');
        }

        // Generate QR Code (sama seperti AssetController)
        $qrCode = \QrCode::format('svg')->size(200)->errorCorrection('H')->generate($validated['kode_aset']);
        $qrPath = 'qrcodes/' . $validated['kode_aset'] . '.svg';
        \Illuminate\Support\Facades\Storage::disk('public')->put($qrPath, $qrCode);

        $assetData = collect($validated)->only([
            'kode_aset', 'nama_aset', 'kategori', 'merk', 'tipe',
            'tahun_perolehan', 'nilai_perolehan', 'kondisi', 'lokasi',
            'pemegang_saat_ini', 'keterangan', 'foto'
        ])->toArray();
        $assetData['tipe_dashboard']   = 'biaya';
        $assetData['qr_code']          = $qrPath;
        $assetData['jabatan_pemegang'] = $request->jabatan_pemegang;
        $assetData['alamat_pemegang']  = $request->alamat_pemegang;
        $assetData['nipp_pemegang']    = $request->nipp_pemegang;

        $asset = Asset::create($assetData);

        if ($validated['kategori'] === 'Kendaraan') {
            $vehicleData = collect($validated)->only([
                'nomor_plat', 'model', 'tahun_pembuatan', 'isi_silinder',
                'nomor_rangka', 'nomor_mesin', 'warna', 'bahan_bakar', 'nomor_bpkb'
            ])->filter()->toArray();
            if (!empty($vehicleData)) {
                $vehicleData['asset_id']     = $asset->id;
                $vehicleData['nama_pemilik'] = $asset->pemegang_saat_ini;
                $vehicleData['jabatan']      = $asset->jabatan_pemegang;
                $vehicleData['alamat']       = $asset->alamat_pemegang;
                \App\Models\VehicleDetail::create($vehicleData);
            }
        }

        if ($request->filled('pemegang_saat_ini')) {
            \App\Models\AssetHistory::create([
                'asset_id'             => $asset->id,
                'dari_pemegang'        => null,
                'ke_pemegang'          => $request->pemegang_saat_ini,
                'jabatan_ke'           => $request->jabatan_pemegang,
                'nipp_ke'              => $request->nipp_pemegang,
                'tanggal_serah_terima' => now(),
                'nomor_ba'             => \App\Models\AssetHistory::generateNomorBA(),
                'keterangan'           => 'Penerimaan awal aset'
            ]);
        }

        return redirect()->route('assets-biaya.index')->with('success', 'Aset Biaya berhasil ditambahkan!');
    }

    public function show(Asset $asset)
    {
        $asset->load('histories');
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $users = User::orderBy('name')->get();
        return view('assets.edit-biaya', compact('asset', 'users'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'kode_aset'        => 'required|unique:assets,kode_aset,' . $asset->id,
            'nama_aset'        => 'required',
            'kategori'         => 'required|in:Bangunan,Tanah,Kendaraan,Peralatan,Inventaris Barang dan Perabot Kantor',
            'merk'             => 'nullable',
            'tipe'             => 'nullable',
            'tahun_perolehan'  => 'required|integer',
            'nilai_perolehan'  => 'required|numeric',
            'kondisi'          => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi'           => 'required',
            'pemegang_saat_ini'=> 'nullable',
            'keterangan'       => 'nullable',
            'foto'             => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($asset->foto) Storage::disk('public')->delete($asset->foto);
            $validated['foto'] = $request->file('foto')->store('assets', 'public');
        }
        $validated['pemegang_saat_ini'] = $request->pemegang_saat_ini;
        $asset->update($validated);
        return redirect()->route('assets-biaya.index')->with('success', 'Aset Biaya berhasil diupdate!');
    }

    public function destroy(Asset $asset)
    {
        if ($asset->foto) Storage::disk('public')->delete($asset->foto);
        $asset->delete();
        return redirect()->route('assets-biaya.index')->with('success', 'Aset Biaya berhasil dihapus!');
    }

    public function exportExcel(Request $request)
    {
        $query = Asset::where('tipe_dashboard', 'biaya');
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('kondisi'))  $query->where('kondisi', $request->kondisi);
        if ($request->filled('pemegang')) $query->where('pemegang_saat_ini', $request->pemegang);

        $assets   = $query->get();
        $filename = 'Data_Aset_Biaya_' . date('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($assets) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Kode Aset', 'Nama Aset', 'Kategori', 'Merk', 'Tipe', 'Tahun Perolehan', 'Nilai Perolehan', 'Kondisi', 'Lokasi', 'Pemegang Saat Ini', 'Keterangan']);
            foreach ($assets as $asset) {
                fputcsv($file, [
                    $asset->kode_aset, $asset->nama_aset, $asset->kategori,
                    $asset->merk, $asset->tipe, $asset->tahun_perolehan,
                    $asset->nilai_perolehan, $asset->kondisi, $asset->lokasi,
                    $asset->pemegang_saat_ini, $asset->keterangan,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}