<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetDetail;
use App\Models\AssetMaintenance;
use App\Models\AssetDepreciation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetDetailController extends Controller
{
    public function show(Asset $asset)
    {
        $asset->load('assetDetail', 'histories', 'changeLogs');
        $maintenances = AssetMaintenance::where('asset_id', $asset->id)->latest()->get();

        $totalBiaya    = $maintenances->sum('biaya');
        $biayaPerJenis = $maintenances->groupBy('jenis_pemeliharaan')
            ->map(fn($g) => $g->sum('biaya'));

        // Ambil penyusutan lewat relasi details, bukan query asset_id langsung
        $depreciation        = AssetDepreciation::with('details')->where('asset_id', $asset->id)->first();
        $depreciationDetails = $depreciation?->details()->orderBy('tahun')->get() ?? collect();

        return view('asset-details.show', compact(
            'asset', 'maintenances', 'totalBiaya', 'biayaPerJenis',
            'depreciation', 'depreciationDetails'
        ));
    }

    public function updateDetail(Request $request, Asset $asset)
    {
        $kategori = $asset->kategori;
        $rules    = ['catatan' => 'nullable|string'];

        if (in_array($kategori, ['Bangunan', 'Gedung'])) {
            $rules += [
                'luas_bangunan' => 'nullable|string',
                'jumlah_lantai' => 'nullable|string',
                'konstruksi'    => 'nullable|string',
                'nomor_imb'     => 'nullable|string',
                'tanggal_imb'   => 'nullable|date',
            ];
        } elseif ($kategori === 'Tanah') {
            $rules += [
                'luas_tanah'         => 'nullable|string',
                'nomor_sertifikat'   => 'nullable|string',
                'tanggal_sertifikat' => 'nullable|date',
                'jenis_sertifikat'   => 'nullable|string',
                'berlaku_sampai'     => 'nullable|date',
            ];
        } elseif (in_array($kategori, ['Peralatan', 'Inventaris Barang dan Perabot Kantor'])) {
            $rules += [
                'nomor_seri'     => 'nullable|string',
                'spesifikasi'    => 'nullable|string',
                'garansi_sampai' => 'nullable|string',
                'lokasi_detail'  => 'nullable|string',
            ];
        } else {
            $rules += [
                'nomor_seri'     => 'nullable|string',
                'spesifikasi'    => 'nullable|string',
                'garansi_sampai' => 'nullable|string',
                'lokasi_detail'  => 'nullable|string',
            ];
        }

        $validated             = $request->validate($rules);
        $validated['asset_id'] = $asset->id;

        AssetDetail::updateOrCreate(['asset_id' => $asset->id], $validated);

        return redirect()->back()->with('success', 'Detail aset berhasil disimpan!');
    }

    public function storeMaintenance(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'tanggal'            => 'required|date',
            'jenis_pemeliharaan' => 'required|string',
            'keterangan'         => 'nullable|string',
            'biaya'              => 'nullable|numeric',
            'vendor'             => 'nullable|string',
            'file_nota'          => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('file_nota')) {
            $validated['file_nota'] = $request->file('file_nota')->store('maintenance-notes', 'public');
        }

        $validated['asset_id'] = $asset->id;
        AssetMaintenance::create($validated);

        return redirect()->back()->with('success', 'Data pemeliharaan berhasil ditambahkan!');
    }

    public function deleteMaintenance(Asset $asset, AssetMaintenance $maintenance)
    {
        if ($maintenance->file_nota) {
            Storage::disk('public')->delete($maintenance->file_nota);
        }
        $maintenance->delete();
        return redirect()->back()->with('success', 'Data pemeliharaan berhasil dihapus!');
    }
}