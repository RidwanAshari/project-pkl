<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\VehicleDetail;
use App\Models\VehicleMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    // Halaman detail kendaraan
    public function show(Asset $asset)
    {
        // Pastikan aset adalah kategori kendaraan
        if ($asset->kategori !== 'Kendaraan') {
            return redirect()->route('assets.show', $asset)->with('error', 'Aset ini bukan kategori kendaraan!');
        }

        $vehicleDetail = $asset->vehicleDetail;
        $maintenances = $asset->vehicleMaintenances()->latest()->paginate(10);
        
        // Statistik
        $totalBiaya = $asset->vehicleMaintenances()->sum('biaya');
        $totalBBM = $asset->vehicleMaintenances()->where('jenis_servis', 'Pengisian BBM')->sum('biaya');
        $totalService = $asset->vehicleMaintenances()->whereIn('jenis_servis', ['Service Rutin', 'Perbaikan', 'Penggantian'])->sum('biaya');
        $totalPajak = $asset->vehicleMaintenances()->where('jenis_servis', 'Bayar Pajak')->sum('biaya');

        return view('vehicles.show', compact('asset', 'vehicleDetail', 'maintenances', 'totalBiaya', 'totalBBM', 'totalService', 'totalPajak'));
    }

    // Form edit identitas kendaraan
    public function editIdentity(Asset $asset)
    {
        if ($asset->kategori !== 'Kendaraan') {
            return redirect()->route('assets.show', $asset);
        }

        $vehicleDetail = $asset->vehicleDetail ?? new VehicleDetail();
        return view('vehicles.edit-identity', compact('asset', 'vehicleDetail'));
    }

    // Update identitas kendaraan
    public function updateIdentity(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'nama_pemilik' => 'nullable|string',
            'alamat' => 'nullable|string',
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

        $validated['asset_id'] = $asset->id;

        VehicleDetail::updateOrCreate(
            ['asset_id' => $asset->id],
            $validated
        );

        return redirect()->route('vehicles.show', $asset)->with('success', 'Identitas kendaraan berhasil diupdate!');
    }

    // Form tambah maintenance
    public function createMaintenance(Asset $asset)
    {
        if ($asset->kategori !== 'Kendaraan') {
            return redirect()->route('assets.show', $asset);
        }

        return view('vehicles.create-maintenance', compact('asset'));
    }

    // Store maintenance
    public function storeMaintenance(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis_servis' => 'required|in:Pengisian BBM,Service Rutin,Perbaikan,Penggantian,Bayar Pajak',
            'jenis_bbm' => 'nullable|string',
            'jumlah_liter' => 'nullable|numeric',
            'harga_per_liter' => 'nullable|numeric',
            'odometer' => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'bengkel' => 'nullable|string',
            'biaya' => 'required|numeric',
            'file_nota' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $validated['asset_id'] = $asset->id;

        // Upload file nota jika ada
        if ($request->hasFile('file_nota')) {
            $validated['file_nota'] = $request->file('file_nota')->store('vehicle-maintenances', 'public');
        }

        $maintenance = VehicleMaintenance::create($validated);

        // Generate Surat Pengantar untuk Service Rutin, Perbaikan, Penggantian
        if (in_array($validated['jenis_servis'], ['Service Rutin', 'Perbaikan', 'Penggantian'])) {
            $this->generateSuratPengantar($asset, $maintenance);
        }

        return redirect()->route('vehicles.show', $asset)->with('success', 'Data pemeliharaan berhasil ditambahkan!');
    }

    // Generate Surat Pengantar PDF
    private function generateSuratPengantar($asset, $maintenance)
    {
        $vehicleDetail = $asset->vehicleDetail;
        
        $pdf = \PDF::loadView('vehicles.surat-pengantar', compact('asset', 'maintenance', 'vehicleDetail'));
        
        $filename = 'surat-pengantar-' . $asset->kode_aset . '-' . $maintenance->id . '.pdf';
        $path = 'surat-pengantar/' . $filename;
        
        Storage::disk('public')->put($path, $pdf->output());
        
        // Update maintenance dengan file surat
        $maintenance->update(['file_surat_pengantar' => $path]);
    }

    // Download Surat Pengantar
    public function downloadSuratPengantar(Asset $asset, VehicleMaintenance $maintenance)
    {
        if (!$maintenance->file_surat_pengantar) {
            return redirect()->back()->with('error', 'Surat pengantar tidak tersedia!');
        }

        return response()->download(storage_path('app/public/' . $maintenance->file_surat_pengantar));
    }

    // Delete maintenance
    public function deleteMaintenance(Asset $asset, VehicleMaintenance $maintenance)
    {
        // Hapus file nota jika ada
        if ($maintenance->file_nota) {
            Storage::disk('public')->delete($maintenance->file_nota);
        }

        $maintenance->delete();

        return redirect()->route('vehicles.show', $asset)->with('success', 'Data pemeliharaan berhasil dihapus!');
    }

    // Laporan biaya kendaraan
    public function reportCost(Asset $asset)
    {
        if ($asset->kategori !== 'Kendaraan') {
            return redirect()->route('assets.show', $asset);
        }

        // Data per bulan tahun ini
        $year = request('year', date('Y'));
        
        // SQLite compatible - pakai strftime
        $monthlyData = VehicleMaintenance::where('asset_id', $asset->id)
            ->whereYear('tanggal', $year)
            ->selectRaw("CAST(strftime('%m', tanggal) AS INTEGER) as bulan, jenis_servis, SUM(biaya) as total")
            ->groupBy('bulan', 'jenis_servis')
            ->get();

        return view('vehicles.report-cost', compact('asset', 'monthlyData', 'year'));
    }
}