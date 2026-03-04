<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\VehicleDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets     = Asset::count();
        $totalValue      = Asset::sum('nilai_perolehan');
        $needMaintenance = Asset::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count();

        $assetsByCondition = Asset::selectRaw('kondisi, count(*) as total')
            ->groupBy('kondisi')->pluck('total', 'kondisi');

        $assetsByCategory = Asset::selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')->pluck('total', 'kategori');

        $recentActivities = AssetHistory::with('asset')
            ->latest()->take(8)->get();

        // Ambil setting threshold dari session/config (default 90 hari)
        $threshold = session('stnk_threshold', 90);

        // Kendaraan dengan STNK yang akan/sudah expired
        $stnkAlerts = VehicleDetail::with('asset')
            ->whereNotNull('tanggal_berlaku')
            ->get()
            ->map(function($vd) use ($threshold) {
                $tgl        = Carbon::parse($vd->tanggal_berlaku);
                $hariSisa   = Carbon::today()->diffInDays($tgl, false); // negatif = sudah lewat
                $status     = null;

                if ($hariSisa < 0) {
                    $status = 'expired';
                } elseif ($hariSisa <= 30) {
                    $status = 'kritis';      // merah
                } elseif ($hariSisa <= $threshold) {
                    $status = 'warning';     // kuning
                }

                $vd->hari_sisa = $hariSisa;
                $vd->status    = $status;
                return $vd;
            })
            ->filter(fn($vd) => $vd->status !== null)
            ->sortBy('hari_sisa');

        return view('dashboard', compact(
            'totalAssets', 'totalValue', 'needMaintenance',
            'assetsByCondition', 'assetsByCategory', 'recentActivities',
            'stnkAlerts', 'threshold'
        ));
    }

    /**
     * API endpoint untuk browser push notification (dipanggil JS setiap X menit)
     */
    public function stnkNotifApi(Request $request)
    {
        $threshold = session('stnk_threshold', 90);

        $alerts = VehicleDetail::with('asset')
            ->whereNotNull('tanggal_berlaku')
            ->get()
            ->filter(function($vd) use ($threshold) {
                $hariSisa = Carbon::today()->diffInDays(Carbon::parse($vd->tanggal_berlaku), false);
                return $hariSisa <= $threshold;
            })
            ->map(function($vd) {
                $hariSisa = Carbon::today()->diffInDays(Carbon::parse($vd->tanggal_berlaku), false);
                return [
                    'nama'      => $vd->asset->nama_aset ?? 'Kendaraan',
                    'nopol'     => $vd->nomor_plat,
                    'hari_sisa' => $hariSisa,
                    'tgl'       => Carbon::parse($vd->tanggal_berlaku)->format('d/m/Y'),
                    'status'    => $hariSisa < 0 ? 'expired' : ($hariSisa <= 30 ? 'kritis' : 'warning'),
                    'url'       => route('vehicles.show', $vd->asset_id),
                ];
            })->values();

        return response()->json($alerts);
    }

    /**
     * Simpan setting threshold
     */
    public function setThreshold(Request $request)
    {
        $request->validate(['threshold' => 'required|integer|min:7|max:365']);
        session(['stnk_threshold' => $request->threshold]);
        return back()->with('success', 'Setting notifikasi disimpan!');
    }
}