<?php

namespace App\Http\Controllers;

use App\Models\VehicleMaintenance;
use Illuminate\Http\Request;

class DpbController extends Controller
{
    // Inbox nota: yang sudah ada file_nota & surat approved & belum jadi dpb
    public function inbox()
    {
        $maintenances = VehicleMaintenance::with('asset')
            ->whereNotNull('file_nota')
            ->where('status_surat', 'approved')
            ->where(function ($q) {
                $q->whereNull('dpb_status')->orWhere('dpb_status', '!=', 'approved');
            })
            ->latest()
            ->paginate(10);

        return view('finance.dpb.inbox', compact('maintenances'));
    }

    // Form input DPB (items)
    public function create(VehicleMaintenance $maintenance)
    {
        if (!$maintenance->file_nota) {
            return back()->with('error', 'Nota belum diupload.');
        }

        if ($maintenance->status_surat !== 'approved') {
            return back()->with('error', 'Surat belum di-ACC kabag.');
        }

        return view('finance.dpb.create', compact('maintenance'));
    }

    // Simpan DPB
    public function store(Request $request, VehicleMaintenance $maintenance)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.nama' => 'required|string',
            'items.*.harga' => 'required|numeric|min:0',
            'dicetak_di' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $payload = [
            'items' => $request->items,
            'dicetak_di' => $request->dicetak_di,
            'keterangan' => $request->keterangan,
        ];

        $maintenance->nota = json_encode($payload);
        $maintenance->dpb_status = 'approved';
        $maintenance->save();

        return redirect()->route('finance.dpb.show', $maintenance->id)
            ->with('success', 'DPB berhasil dibuat.');
    }

    // Lihat / Print DPB
    public function show(VehicleMaintenance $dpb)
    {
        if ($dpb->dpb_status !== 'approved') {
            return back()->with('error', 'DPB belum dibuat.');
        }

        return view('finance.dpb.show', compact('dpb'));
    }
}