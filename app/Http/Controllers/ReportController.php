<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::count();
        $totalValue = Asset::sum('nilai_perolehan');
        $goodAssets = Asset::where('kondisi', 'Baik')->count();
        $categoriesCount = Asset::distinct('kategori')->count('kategori');
        
        return view('reports.index', compact(
            'totalAssets', 
            'totalValue', 
            'goodAssets', 
            'categoriesCount'
        ));
    }

    public function byCategory()
    {
        $assets = Asset::withCount('histories')
            ->groupBy('kategori')
            ->selectRaw('kategori, count(*) as total, sum(nilai_perolehan) as total_value')
            ->get();
            
        return view('reports.by-category', compact('assets'));
    }

    public function byCondition()
    {
        $assets = Asset::groupBy('kondisi')
            ->selectRaw('kondisi, count(*) as total, sum(nilai_perolehan) as total_value')
            ->get();
            
        return view('reports.by-condition', compact('assets'));
    }

    public function byHolder()
    {
        $assets = Asset::whereNotNull('pemegang_saat_ini')
            ->groupBy('pemegang_saat_ini')
            ->selectRaw('pemegang_saat_ini, count(*) as total, sum(nilai_perolehan) as total_value')
            ->get();
            
        return view('reports.by-holder', compact('assets'));
    }

    public function pdf(Request $request)
    {
        // Query dengan filter
        $query = Asset::query();
        
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_aset', 'like', "%{$search}%")
                  ->orWhere('nama_aset', 'like', "%{$search}%");
            });
        }
        
        $assets = $query->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', compact('assets'));
        
        return $pdf->download('laporan-aset-' . date('Y-m-d') . '.pdf');
    }

    public function export(Request $request)
    {
        // Query yang sama seperti di pdf()
        $query = Asset::query();
        
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_aset', 'like', "%{$search}%")
                  ->orWhere('nama_aset', 'like', "%{$search}%");
            });
        }
        
        $assets = $query->get();
        
        // Implement Excel export here
        // return Excel::download(new AssetsExport($assets), 'assets.xlsx');
        
        return redirect()->back()->with('info', 'Export feature coming soon');
    }
}