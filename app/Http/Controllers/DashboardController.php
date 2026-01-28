<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalAssets' => Asset::count(),
            'totalValue' => Asset::sum('nilai_perolehan'),
            'assetsByCondition' => Asset::groupBy('kondisi')
                ->selectRaw('kondisi, count(*) as total')
                ->get(),
            'recentAssets' => Asset::latest()->take(5)->get(),
            'recentTransfers' => AssetHistory::with('asset')
                ->latest()
                ->take(5)
                ->get(),
            'assetsByCategory' => Asset::groupBy('kategori')
                ->selectRaw('kategori, count(*) as total')
                ->get()
        ];

        return view('dashboard', $stats);
    }
}