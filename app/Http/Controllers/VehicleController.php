<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\VehicleMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    // ===============================
    // DETAIL KENDARAAN
    // ===============================
    public function show(Asset $asset)
    {
        if ($asset->kategori !== 'Kendaraan') {
            return redirect()->route('assets.show', $asset)
                ->with('error', 'Aset ini bukan kategori kendaraan!');
        }

        $vehicleDetail = $asset->vehicleDetail;
        $maintenances = $asset->vehicleMaintenances()->latest()->paginate(10);

        $totalBiaya = $asset->vehicleMaintenances()->sum('biaya');

        $totalBBM = $asset->vehicleMaintenances()
            ->where('jenis_servis', 'Pengisian BBM')
            ->sum('biaya');

        $totalService = $asset->vehicleMaintenances()
            ->whereIn('jenis_servis', ['Service Rutin', 'Perbaikan', 'Penggantian'])
            ->sum('biaya');

        $totalPajak = $asset->vehicleMaintenances()
            ->where('jenis_servis', 'Bayar Pajak')
            ->sum('biaya');

        return view('vehicles.show', compact(
            'asset',
            'vehicleDetail',
            'maintenances',
            'totalBiaya',
            'totalBBM',
            'totalService',
            'totalPajak'
        ));
    }

    // ===============================
    // HALAMAN KABAG
    // ===============================
    public function accIndex()
    {
        $maintenances = VehicleMaintenance::with('asset')
            ->orderByRaw("
                CASE 
                    WHEN status_surat = 'pending' THEN 0
                    WHEN status_surat = 'rejected' THEN 1
                    WHEN status_surat = 'approved' THEN 2
                END
            ")
            ->orderByDesc('id')
            ->paginate(10);

        return view('kabag.acc-surat', compact('maintenances'));
    }

    // ===============================
    // ACC
    // ===============================
    public function accSurat($id)
    {
        $maintenance = VehicleMaintenance::findOrFail($id);

        $maintenance->status_surat = 'approved';
        $maintenance->save();

        return back()->with('success', 'Surat berhasil di ACC Kabag!');
    }

    // ===============================
    // REJECT
    // ===============================
    public function rejectSurat($id)
    {
        $maintenance = VehicleMaintenance::findOrFail($id);

        $maintenance->status_surat = 'rejected';
        $maintenance->save();

        return back()->with('success', 'Surat ditolak.');
    }

    // ===============================
    // REVIEW SURAT
    // ===============================
    public function reviewSuratPengantar(VehicleMaintenance $maintenance)
    {
        if (!$maintenance->file_surat_pengantar) {
            return back()->with('error', 'Surat tidak tersedia!');
        }

        return response()->file(
            storage_path('app/public/' . $maintenance->file_surat_pengantar)
        );
    }

    // ===============================
    // DOWNLOAD (HANYA APPROVED)
    // ===============================
    public function downloadSuratPengantar(Asset $asset, VehicleMaintenance $maintenance)
    {
        if ($maintenance->asset_id !== $asset->id) {
            abort(404);
        }

        if ($maintenance->status_surat !== 'approved') {
            return back()->with('error', 'Surat belum di ACC Kabag!');
        }

        return response()->download(
            storage_path('app/public/' . $maintenance->file_surat_pengantar)
        );
    }

    // ===============================
    // CREATE MAINTENANCE
    // ===============================
    public function createMaintenance(Asset $asset)
    {
        return view('vehicles.create-maintenance', compact('asset'));
    }

    // ===============================
    // STORE MAINTENANCE
    // ===============================
    public function storeMaintenance(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis_servis' => 'required',
            'biaya' => 'required|numeric',
            'file_nota' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $validated['asset_id'] = $asset->id;
        $validated['status_surat'] = 'pending';

        $maintenance = VehicleMaintenance::create($validated);

        if (in_array($validated['jenis_servis'], ['Service Rutin', 'Perbaikan', 'Penggantian'])) {
            $this->generateSuratPengantar($asset, $maintenance);
        }

        return redirect()->route('vehicles.show', $asset)
            ->with('success', 'Data berhasil ditambahkan!');
    }

    // ===============================
    // GENERATE PDF
    // ===============================
    private function generateSuratPengantar($asset, $maintenance)
    {
        $pdf = \PDF::loadView(
            'vehicles.surat-pengantar',
            compact('asset', 'maintenance')
        );

        $filename = 'surat-pengantar-' . $maintenance->id . '.pdf';
        $path = 'surat-pengantar/' . $filename;

        Storage::disk('public')->put($path, $pdf->output());

        $maintenance->file_surat_pengantar = $path;
        $maintenance->save();
    }

    // ===============================
    // DELETE
    // ===============================
    public function deleteMaintenance(Asset $asset, VehicleMaintenance $maintenance)
    {
        $maintenance->delete();

        return back()->with('success', 'Data berhasil dihapus!');
    }

    //up nota
    public function uploadNota(Request $request, $id)
{
    $maintenance = VehicleMaintenance::findOrFail($id);

    if ($maintenance->status_surat !== 'approved') {
        return back()->with('error', 'Belum disetujui Kabag.');
    }

    $request->validate([
        'file_nota' => 'required|file|mimes:jpg,png,pdf|max:2048'
    ]);

    $path = $request->file('file_nota')
                    ->store('nota_service', 'public');

    $maintenance->update([
        'file_nota' => $path
    ]);

    return back()->with('success', 'Nota berhasil diupload.');
}

}
