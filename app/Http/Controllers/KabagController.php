<?php

namespace App\Http\Controllers;

use App\Models\VehicleMaintenance;
use App\Models\DpbDocument;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KabagController extends Controller
{
    public function index()
    {
        $jabatan = auth()->user()->position ?? '';
        $isEko   = str_contains($jabatan, 'Ka Sub Bag'); // Pak Eko
        $isFajar = !$isEko; // Pak Fajar atau kabag lain

        // Tahap 1: hanya Fajar yang bisa lihat & approve
        $menungguAcc = $isFajar
            ? VehicleMaintenance::with('asset')->where('status_surat', 'menunggu_acc')->latest()->get()
            : collect();

        // Tahap 2: hanya Eko yang bisa lihat & approve
        $menungguEko = $isEko
            ? VehicleMaintenance::with('asset')->where('status_surat', 'menunggu_eko')->latest()->get()
            : collect();

        $sudahDisetujui = VehicleMaintenance::with('asset')
            ->where('status_surat', 'disetujui')
            ->latest()->take(10)->get();

        $ditolak = VehicleMaintenance::with('asset')
            ->where('status_surat', 'ditolak')
            ->latest()->take(10)->get();

        return view('kabag.dashboard', compact(
            'menungguAcc', 'menungguEko', 'sudahDisetujui', 'ditolak', 'isEko', 'isFajar'
        ));
    }

    public function showSurat(VehicleMaintenance $maintenance)
    {
        $maintenance->load('asset.vehicleDetail');
        return view('kabag.review-surat', compact('maintenance'));
    }

    /**
     * Approve oleh Fajar (Kabag) — status jadi menunggu_eko
     */
    public function approve(Request $request, VehicleMaintenance $maintenance)
    {
        $jabatan = auth()->user()->position ?? '';
        if (str_contains($jabatan, 'Ka Sub Bag')) {
            return redirect()->back()->with('error', 'Hanya Kabag yang bisa melakukan persetujuan tahap ini.');
        }

        $request->validate([
            'file_surat_ttd' => 'required|file|mimes:pdf|max:5120',
        ]);

        $path = $request->file('file_surat_ttd')->store('surat-ttd', 'public');

        $maintenance->update([
            'status_surat'   => 'menunggu_eko', // lanjut ke Eko
            'file_surat_ttd' => $path,
            'approved_at'    => now(),
            'approved_by'    => auth()->user()->name,
        ]);

        return redirect()->route('kabag.index')
            ->with('success', 'Surat disetujui oleh ' . auth()->user()->name . '. Menunggu verifikasi Ka.Sub.bag.');
    }

    /**
     * Approve oleh Eko (Ka.Sub.bag.) — status jadi disetujui, surat bisa diunduh
     */
    public function approveEko(Request $request, VehicleMaintenance $maintenance)
    {
        $jabatan = auth()->user()->position ?? '';
        if (!str_contains($jabatan, 'Ka Sub Bag')) {
            return redirect()->back()->with('error', 'Hanya Ka.Sub.bag. yang bisa melakukan verifikasi tahap ini.');
        }

        if ($maintenance->status_surat !== 'menunggu_eko') {
            return redirect()->back()->with('error', 'Surat belum disetujui Kabag.');
        }

        $request->validate([
            'file_surat_ttd_eko' => 'required|file|mimes:pdf|max:5120',
        ]);

        $path = $request->file('file_surat_ttd_eko')->store('surat-ttd-eko', 'public');

        $maintenance->update([
            'status_surat'    => 'disetujui',
            'file_surat_ttd_eko' => $path,
            'approved_at_eko' => now(),
            'approved_by_eko' => auth()->user()->name,
            // terkirim_ke_finance di-set oleh Finance saat input biaya
        ]);

        return redirect()->route('kabag.index')
            ->with('success', 'Surat pengantar selesai diverifikasi. Siap dikirim ke Finance.');
    }

    /**
     * Tolak surat (bisa dilakukan Fajar atau Eko)
     */
    public function reject(Request $request, VehicleMaintenance $maintenance)
    {
        $request->validate(['alasan_tolak' => 'required|string']);

        $maintenance->update([
            'status_surat' => 'ditolak',
            'keterangan'   => $maintenance->keterangan . ' | DITOLAK: ' . $request->alasan_tolak,
        ]);

        return redirect()->route('kabag.index')->with('success', 'Surat pengantar ditolak.');
    }
}