<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets    = Asset::count();
        $totalValue     = Asset::sum('nilai_perolehan');
        $needMaintenance = Asset::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count();

        $assetsByCondition = Asset::selectRaw('kondisi, count(*) as total')
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi');

        $assetsByCategory = Asset::selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        // Aktivitas terbaru (dipindah dari profil ke dashboard)
        $recentActivities = AssetHistory::with('asset')
            ->latest()
            ->take(8)
            ->get();

        return view('dashboard', compact(
            'totalAssets',
            'totalValue',
            'needMaintenance',
            'assetsByCondition',
            'assetsByCategory',
            'recentActivities'
        ));
    }
}