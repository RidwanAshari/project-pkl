<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\VehicleMaintenance;
use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function show(Asset $asset)
    {
        // Load relasi yang diperlukan
        $asset->load(['vehicleDetail', 'vehicleMaintenances' => function($q) {
            $q->latest();
        }]);

        // Hitung statistik biaya
        $totalBiaya = $asset->vehicleMaintenances()->sum('biaya');
        $biayaBBM   = $asset->vehicleMaintenances()->where('jenis_servis', 'Pengisian BBM')->sum('biaya');
        $biayaService = $asset->vehicleMaintenances()
            ->whereIn('jenis_servis', ['Service Rutin', 'Perbaikan', 'Penggantian'])
            ->sum('biaya');
        $biayaPajak = $asset->vehicleMaintenances()->where('jenis_servis', 'Bayar Pajak')->sum('biaya');

        $vehicleDetail = $asset->vehicleDetail;

        return view('vehicles.show', compact('asset', 'vehicleDetail', 'totalBiaya', 'biayaBBM', 'biayaService', 'biayaPajak'));
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

        // Merge biaya dari BBM atau Pajak
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

        if ($request->hasFile('file_nota')) {
            $data['file_nota'] = $request->file('file_nota')->store('maintenance', 'public');
        }

        VehicleMaintenance::create($data);

        return redirect()->route('vehicles.show', $asset)->with('success', 'Data pemeliharaan berhasil ditambahkan!');
    }

    public function deleteMaintenance(Asset $asset, VehicleMaintenance $maintenance)
    {
        if ($maintenance->file_nota) {
            Storage::disk('public')->delete($maintenance->file_nota);
        }
        $maintenance->delete();
        return redirect()->route('vehicles.show', $asset)->with('success', 'Data pemeliharaan berhasil dihapus!');
    }

    public function downloadSuratPengantar(Asset $asset, VehicleMaintenance $maintenance)
    {
        $vehicleDetail = $asset->vehicleDetail;
        $pdf = \PDF::loadView('vehicles.surat-pengantar', compact('asset', 'vehicleDetail', 'maintenance'));
        return $pdf->download('Surat_Pengantar_' . $asset->kode_aset . '.pdf');
    }
}