<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total aset
        $totalAssets = Asset::count();
        
        // Total nilai aset
        $totalValue = Asset::sum('nilai_perolehan');
        
        // Aset berdasarkan kondisi
        $assetsByCondition = Asset::select('kondisi', DB::raw('count(*) as total'))
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi');
        
        // Aset berdasarkan kategori
        $assetsByCategory = Asset::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori');
        
        // Aset yang perlu maintenance (contoh: kondisi rusak ringan/berat)
        $needMaintenance = Asset::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count();
        
        return view('dashboard', compact(
            'totalAssets',
            'totalValue',
            'assetsByCondition',
            'assetsByCategory',
            'needMaintenance'
        ));
    }
}