<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    // Laporan Per Kategori
    public function byCategory()
    {
        $data = Asset::select('kategori', DB::raw('count(*) as jumlah'), DB::raw('sum(nilai_perolehan) as total_nilai'))
            ->groupBy('kategori')
            ->get();

        return view('reports.by-category', compact('data'));
    }

    // Laporan Per Kondisi
    public function byCondition()
    {
        $data = Asset::select('kondisi', DB::raw('count(*) as jumlah'), DB::raw('sum(nilai_perolehan) as total_nilai'))
            ->groupBy('kondisi')
            ->get();

        return view('reports.by-condition', compact('data'));
    }

    // Laporan Per Pemegang
    public function byHolder()
    {
        $data = Asset::select('pemegang_saat_ini', DB::raw('count(*) as jumlah'), DB::raw('sum(nilai_perolehan) as total_nilai'))
            ->whereNotNull('pemegang_saat_ini')
            ->groupBy('pemegang_saat_ini')
            ->get();

        return view('reports.by-holder', compact('data'));
    }

    // Export PDF Laporan Lengkap
    public function exportPDF()
    {
        $assets = Asset::all();
        $totalNilai = Asset::sum('nilai_perolehan');
        $byCategory = Asset::select('kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('kategori')
            ->get();
        $byCondition = Asset::select('kondisi', DB::raw('count(*) as jumlah'))
            ->groupBy('kondisi')
            ->get();

        $pdf = \PDF::loadView('reports.pdf', compact('assets', 'totalNilai', 'byCategory', 'byCondition'));
        
        return $pdf->download('Laporan_Aset_' . date('Y-m-d') . '.pdf');
    }
}