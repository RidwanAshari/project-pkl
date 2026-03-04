<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\VehicleMaintenance;
use App\Models\AssetDepreciation;
use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function show(Asset $asset)
    {
        $asset->load(['vehicleDetail', 'vehicleMaintenances' => function($q) {
            $q->latest();
        }]);

        $totalBiaya   = $asset->vehicleMaintenances()->sum('biaya');
        $biayaBBM     = $asset->vehicleMaintenances()->where('jenis_servis', 'Pengisian BBM')->sum('biaya');
        $biayaService = $asset->vehicleMaintenances()
            ->whereIn('jenis_servis', ['Service Rutin', 'Perbaikan', 'Penggantian'])
            ->sum('biaya');
        $biayaPajak   = $asset->vehicleMaintenances()->where('jenis_servis', 'Bayar Pajak')->sum('biaya');

        $vehicleDetail = $asset->vehicleDetail;

        // Penyusutan — ambil lewat relasi, bukan query asset_id langsung
        $depreciation        = AssetDepreciation::with('details')->where('asset_id', $asset->id)->first();
        $depDetails          = $depreciation?->details()->orderBy('tahun')->get() ?? collect();
        $nilaiSekarang       = $depDetails->last()?->nilai_buku ?? $asset->nilai_perolehan;

        return view('vehicles.show', compact(
            'asset', 'vehicleDetail', 'totalBiaya', 'biayaBBM', 'biayaService', 'biayaPajak',
            'depreciation', 'depDetails', 'nilaiSekarang'
        ));
    }

    public function createMaintenance(Asset $asset)
    {
        $bengkels = Bengkel::orderBy('nama')->get();
        return view('vehicles.create-maintenance', compact('asset', 'bengkels'));
    }

    public function storeMaintenance(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'tanggal'         => 'required|date',
            'jenis_servis'    => 'required|string',
            'biaya_bbm'       => 'nullable|numeric',
            'biaya_pajak'     => 'nullable|numeric',
            'keterangan'      => 'nullable|string',
            'bengkel'         => 'nullable|string',
            'jenis_bbm'       => 'nullable|string',
            'jumlah_liter'    => 'nullable|numeric',
            'harga_per_liter' => 'nullable|numeric',
            'odometer'        => 'nullable|integer',
            'file_nota'       => 'nullable|file|max:2048',
        ]);

        $biaya = $validated['biaya_bbm'] ?? $validated['biaya_pajak'] ?? 0;

        $data = [
            'asset_id'        => $asset->id,
            'tanggal'         => $validated['tanggal'],
            'jenis_servis'    => $validated['jenis_servis'],
            'biaya'           => $biaya,
            'keterangan'      => $validated['keterangan'] ?? null,
            'bengkel'         => $validated['bengkel'] ?? null,
            'jenis_bbm'       => $validated['jenis_bbm'] ?? null,
            'jumlah_liter'    => $validated['jumlah_liter'] ?? null,
            'harga_per_liter' => $validated['harga_per_liter'] ?? null,
            'odometer'        => $validated['odometer'] ?? null,
        ];

        if (in_array($validated['jenis_servis'], ['Service Rutin', 'Perbaikan', 'Penggantian'])) {
            $data['status_surat'] = 'menunggu_acc';
        }

        if ($request->hasFile('file_nota')) {
            $data['file_nota'] = $request->file('file_nota')->store('maintenance', 'public');
        }

        VehicleMaintenance::create($data);

        return redirect()->route('vehicles.show', $asset)
            ->with('success', 'Data pemeliharaan berhasil ditambahkan! Surat pengantar sedang menunggu persetujuan Kepala Bagian.');
    }

    public function deleteMaintenance(Asset $asset, VehicleMaintenance $maintenance)
    {
        if ($maintenance->file_nota) Storage::disk('public')->delete($maintenance->file_nota);
        if ($maintenance->file_nota_bengkel) Storage::disk('public')->delete($maintenance->file_nota_bengkel);
        if ($maintenance->file_surat_ttd) Storage::disk('public')->delete($maintenance->file_surat_ttd);
        $maintenance->delete();
        return redirect()->route('vehicles.show', $asset)->with('success', 'Data pemeliharaan berhasil dihapus!');
    }

    public function downloadSuratPengantar(Asset $asset, VehicleMaintenance $maintenance)
    {
        $vehicleDetail = $asset->vehicleDetail;
        $pdf = \PDF::loadView('vehicles.surat-pengantar', compact('asset', 'vehicleDetail', 'maintenance'));
        return $pdf->download('Surat_Pengantar_' . $asset->kode_aset . '.pdf');
    }

    public function formInputBiaya(Asset $asset, VehicleMaintenance $maintenance)
    {
        return view('vehicles.input-biaya', compact('asset', 'maintenance'));
    }

    public function editIdentity(Asset $asset)
    {
        $vehicleDetail = $asset->vehicleDetail;
        return view('vehicles.edit-identity', compact('asset', 'vehicleDetail'));
    }

    public function updateIdentity(Request $request, Asset $asset)
    {
        $validated = $request->validate([
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
            'warna_tnkb'       => 'nullable|string',
            'tahun_registrasi' => 'nullable|integer',
            'nomor_bpkb'       => 'nullable|string',
            'tanggal_berlaku'  => 'nullable|date',
            'berat'            => 'nullable|numeric',
            'sumbu'            => 'nullable|integer',
            'penumpang'        => 'nullable|integer',
        ]);

        $validated['asset_id'] = $asset->id;
        \App\Models\VehicleDetail::updateOrCreate(
            ['asset_id' => $asset->id],
            $validated
        );

        return redirect()->route('vehicles.show', $asset)->with('success', 'Identitas kendaraan berhasil diupdate!');
    }

    public function reportCost(Asset $asset)
    {
        $asset->load('vehicleMaintenances');
        $byMonth = $asset->vehicleMaintenances()
            ->selectRaw('strftime("%Y-%m", tanggal) as bulan, sum(biaya) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        return view('vehicles.report-cost', compact('asset', 'byMonth'));
    }

    public function saveDepreciation(Request $request, Asset $asset)
    {
        app(DepreciationController::class)->store($request, $asset);
        return redirect()->route('vehicles.show', $asset)->with('success', 'Data penyusutan berhasil disimpan!');
    }
}