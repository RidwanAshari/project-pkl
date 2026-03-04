<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetDepreciation;
use App\Models\AssetDepreciationDetail;
use Illuminate\Http\Request;

class DepreciationController extends Controller
{
    /**
     * Simpan konfigurasi penyusutan
     */
    public function store(Request $request, Asset $asset)
    {
        $request->validate([
            'metode'        => 'required|in:garis_lurus,saldo_menurun',
            'umur_ekonomis' => 'required|integer|min:1|max:100',
            'nilai_sisa'    => 'required|numeric|min:0',
            'tahun_mulai'   => 'required|integer|min:1900|max:2100',
            'keterangan'    => 'nullable|string',
        ]);

        AssetDepreciation::updateOrCreate(
            ['asset_id' => $asset->id],
            [
                'asset_id'      => $asset->id,
                'metode'        => $request->metode,
                'umur_ekonomis' => $request->umur_ekonomis,
                'nilai_sisa'    => $request->nilai_sisa,
                'tahun_mulai'   => $request->tahun_mulai,
                'keterangan'    => $request->keterangan,
            ]
        );

        return redirect()->back()->with('success', 'Konfigurasi penyusutan disimpan! Silakan tambahkan data per bulan.');
    }

    /**
     * Tambah satu baris penyusutan manual untuk bulan+tahun tertentu
     */
    public function addDetail(Request $request, Asset $asset)
    {
        $request->validate([
            'tahun'            => 'required|integer|min:1900|max:2100',
            'bulan'            => 'required|integer|min:1|max:12',
            'nilai_awal'       => 'required|numeric|min:0',
            'beban_penyusutan' => 'required|numeric|min:0',
        ]);

        $depreciation = AssetDepreciation::where('asset_id', $asset->id)->first();
        if (!$depreciation) {
            return redirect()->back()->with('error', 'Simpan konfigurasi penyusutan terlebih dahulu!');
        }

        // Cek apakah bulan+tahun sudah ada
        $existing = AssetDepreciationDetail::where('asset_depreciation_id', $depreciation->id)
            ->where('tahun', $request->tahun)
            ->where('bulan', $request->bulan)
            ->first();

        if ($existing) {
            $namaBulan = \Carbon\Carbon::create()->month($request->bulan)->isoFormat('MMMM');
            return redirect()->back()->with('error', "Data {$namaBulan} {$request->tahun} sudah ada! Hapus dulu jika ingin mengubah.");
        }

        // Hitung akumulasi berdasarkan semua periode sebelumnya
        $totalSebelumnya = AssetDepreciationDetail::where('asset_depreciation_id', $depreciation->id)
            ->where(function($q) use ($request) {
                $q->where('tahun', '<', $request->tahun)
                  ->orWhere(function($q2) use ($request) {
                      $q2->where('tahun', $request->tahun)
                         ->where('bulan', '<', $request->bulan);
                  });
            })
            ->sum('beban_penyusutan');

        $akumulasi = $totalSebelumnya + $request->beban_penyusutan;
        $nilaiBuku = max($depreciation->nilai_sisa, $request->nilai_awal - $request->beban_penyusutan);

        AssetDepreciationDetail::create([
            'asset_depreciation_id' => $depreciation->id,
            'tahun'                 => $request->tahun,
            'bulan'                 => $request->bulan,
            'nilai_awal'            => $request->nilai_awal,
            'beban_penyusutan'      => $request->beban_penyusutan,
            'akumulasi_penyusutan'  => $akumulasi,
            'nilai_buku'            => $nilaiBuku,
        ]);

        $namaBulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'][$request->bulan] ?? $request->bulan;
        return redirect()->back()->with('success', "Data penyusutan {$namaBulan} {$request->tahun} berhasil ditambahkan!");
    }

    /**
     * Hapus satu baris detail penyusutan
     */
    public function deleteDetail(Asset $asset, AssetDepreciationDetail $detail)
    {
        $detail->delete();
        return redirect()->back()->with('success', 'Data penyusutan berhasil dihapus!');
    }
}