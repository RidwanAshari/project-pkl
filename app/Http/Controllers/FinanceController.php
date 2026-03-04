<?php

namespace App\Http\Controllers;

use App\Models\VehicleMaintenance;
use App\Models\DpbDocument;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $readyForDpb = VehicleMaintenance::with('asset')
            ->where('terkirim_ke_finance', true)
            ->whereDoesntHave('dpbDocument')
            ->latest()
            ->get();

        $dpbList = DpbDocument::with(['maintenance.asset'])
            ->latest()
            ->paginate(15);

        return view('finance.dashboard', compact('readyForDpb', 'dpbList'));
    }

    public function inputBiaya(Request $request, VehicleMaintenance $maintenance)
    {
        $request->validate([
            'biaya_aktual'      => 'required|numeric|min:0',
            'file_nota_bengkel' => 'required|file|max:5120',
        ]);

        $path = $request->file('file_nota_bengkel')->store('nota-bengkel', 'public');

        $maintenance->update([
            'biaya_aktual'        => $request->biaya_aktual,
            'file_nota_bengkel'   => $path,
            'biaya'               => $request->biaya_aktual,
            'terkirim_ke_finance' => true,
        ]);

        return redirect()->back()->with('success', 'Biaya dan nota berhasil dikirim ke Finance!');
    }

    public function formDpb(VehicleMaintenance $maintenance)
    {
        $asset = $maintenance->asset;

        $tahun = date('Y');
        $num   = DpbDocument::count() + 1;
        do {
            $nomorDpb = 'DPB/' . $tahun . '/' . str_pad($num, 4, '0', STR_PAD_LEFT);
            $exists   = DpbDocument::where('nomor_dpb', $nomorDpb)->exists();
            if ($exists) $num++;
        } while ($exists);

        return view('finance.form-dpb', compact('maintenance', 'asset', 'nomorDpb'));
    }

    public function createDpb(Request $request, VehicleMaintenance $maintenance)
    {
        $request->validate([
            'nomor_dpb'        => 'required|unique:dpb_documents,nomor_dpb',
            'tanggal_dpb'      => 'required|date',
            'nama_bengkel'     => 'nullable|string',
            'untuk_keterangan' => 'nullable|string',
        ]);

        // Parse uraian items dari request
        $namaItems   = $request->input('item_nama', []);
        $volItems    = $request->input('item_vol', []);
        $satuanItems = $request->input('item_satuan', []);
        $hargaItems  = $request->input('item_harga', []);
        $jenisItems  = $request->input('item_jenis', []); // 'barang' atau 'jasa'

        $uraianItems   = [];
        $totalBarang   = 0;
        $totalJasa     = 0;

        foreach ($namaItems as $i => $nama) {
            if (empty(trim($nama))) continue;
            $vol    = (float)($volItems[$i] ?? 1);
            $harga  = (float)($hargaItems[$i] ?? 0);
            $jenis  = $jenisItems[$i] ?? 'barang';
            $jumlah = $vol * $harga;

            $uraianItems[] = [
                'nama'   => trim($nama),
                'vol'    => $vol,
                'satuan' => $satuanItems[$i] ?? '',
                'harga'  => $harga,
                'jumlah' => $jumlah,
                'jenis'  => $jenis, // 'barang' atau 'jasa'
            ];

            if ($jenis === 'jasa') {
                $totalJasa += $jumlah;
            } else {
                $totalBarang += $jumlah;
            }
        }

        // PPh 2% hanya dari biaya jasa
        $totalPph    = round($totalJasa * 0.02);
        $totalBiaya  = $totalBarang + $totalJasa; // PPh hanya info, tidak dipotong

        // Uraian string untuk backward compat
        $uraianStr = collect($uraianItems)->map(fn($it) =>
            $it['nama'].'|'.$it['vol'].'|'.$it['satuan'].'|'.$it['harga'].'|'.$it['jenis']
        )->implode("\n");

        $dpb = DpbDocument::create([
            'maintenance_id'   => $maintenance->id,
            'nomor_dpb'        => $request->nomor_dpb,
            'tanggal_dpb'      => $request->tanggal_dpb,
            'total_biaya'      => $totalBiaya,
            'total_pph'        => $totalPph,
            'uraian'           => $uraianStr,
            'uraian_items'     => $uraianItems,
            'nama_bengkel'     => $request->nama_bengkel ?? $maintenance->bengkel,
            'untuk_keterangan' => $request->untuk_keterangan,
            'dibuat_oleh'      => auth()->id(),
            'status'           => 'final',
            'status_eko'       => 'disetujui',
        ]);

        return redirect()->route('finance.index')
            ->with('success', 'DPB ' . $dpb->nomor_dpb . ' berhasil dibuat!');
    }

    public function downloadDpb(DpbDocument $dpb)
    {
        $maintenance = $dpb->maintenance;
        $asset       = $maintenance->asset ?? null;
        return view('finance.surat-dpb', compact('dpb', 'maintenance', 'asset'));
    }
}