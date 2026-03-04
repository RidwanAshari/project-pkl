<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::where('tipe_dashboard', 'aset');
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('kondisi'))  $query->where('kondisi', $request->kondisi);
        if ($request->filled('pemegang')) $query->where('pemegang_saat_ini', $request->pemegang);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_aset','like',"%{$search}%")
                  ->orWhere('nama_aset','like',"%{$search}%")
                  ->orWhere('pemegang_saat_ini','like',"%{$search}%");
            });
        }
        $assets = $query->latest()->paginate(10);
        $users  = User::orderBy('name')->get();
        return view('assets.index', compact('assets', 'users'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('assets.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_aset'        => 'nullable',
            'nama_aset'        => 'required',
            'kategori'         => 'required|in:Bangunan,Tanah,Kendaraan,Peralatan,Inventaris Barang dan Perabot Kantor',
            'merk'             => 'nullable','tipe'=>'nullable',
            'tahun_perolehan'  => 'required|integer',
            'nilai_perolehan'  => 'required|numeric',
            'kondisi'          => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi'           => 'required',
            'pemegang_saat_ini'=> 'nullable','keterangan'=>'nullable',
            'foto'             => 'nullable|image|max:2048',
            'nomor_plat'       => 'nullable|string','model'=>'nullable|string',
            'tahun_pembuatan'  => 'nullable|integer','isi_silinder'=>'nullable|string',
            'nomor_rangka'     => 'nullable|string','nomor_mesin'=>'nullable|string',
            'warna'            => 'nullable|string','bahan_bakar'=>'nullable|string',
            'warna_tnkb'       => 'nullable|string','tahun_registrasi'=>'nullable|integer',
            'nomor_bpkb'       => 'nullable|string','tanggal_berlaku'=>'nullable|date',
            'bulan_berlaku'    => 'nullable|string','tahun_berlaku'=>'nullable|string',
            'berat'            => 'nullable|numeric','sumbu'=>'nullable|integer','penumpang'=>'nullable|integer',
        ]);

        if (empty($validated['kode_aset'])) {
            $prefix = match($validated['kategori']) {
                'Kendaraan' => 'KND', 'Bangunan' => 'GDG', 'Tanah' => 'TNH', default => 'AST',
            };
            $last = Asset::where('kode_aset','like',$prefix.'-%')->orderByDesc('kode_aset')->first();
            $num  = $last ? ((int)substr($last->kode_aset, strlen($prefix)+1))+1 : 1;
            $validated['kode_aset'] = $prefix.'-'.str_pad($num,4,'0',STR_PAD_LEFT);
        }

        if (Asset::where('kode_aset',$validated['kode_aset'])->exists())
            return back()->withErrors(['kode_aset'=>'Kode aset sudah digunakan.'])->withInput();

        if ($request->hasFile('foto'))
            $validated['foto'] = $request->file('foto')->store('assets','public');

        $qrUrl  = route('assets.qr-redirect', $validated['kode_aset']);
        $qrCode = \QrCode::format('svg')->size(200)->errorCorrection('H')->generate($qrUrl);
        $qrPath = 'qrcodes/'.$validated['kode_aset'].'.svg';
        Storage::disk('public')->put($qrPath, $qrCode);
        $validated['qr_code'] = $qrPath;

        $assetData = collect($validated)->only([
            'kode_aset','nama_aset','kategori','merk','tipe',
            'tahun_perolehan','nilai_perolehan','kondisi','lokasi',
            'pemegang_saat_ini','keterangan','foto','qr_code'
        ])->toArray();
        $assetData['tipe_dashboard']   = 'aset';
        $assetData['jabatan_pemegang'] = $request->jabatan_pemegang;
        $assetData['alamat_pemegang']  = $request->alamat_pemegang;
        $assetData['nipp_pemegang']    = $request->nipp_pemegang;

        $asset = Asset::create($assetData);

        if ($validated['kategori'] === 'Kendaraan') {
            $vehicleData = collect($validated)->only([
                'nomor_plat','model','tahun_pembuatan','isi_silinder',
                'nomor_rangka','nomor_mesin','warna','bahan_bakar',
                'warna_tnkb','tahun_registrasi','nomor_bpkb','tanggal_berlaku',
                'bulan_berlaku','tahun_berlaku','berat','sumbu','penumpang'
            ])->filter()->toArray();
            if (!empty($vehicleData)) {
                $vehicleData['asset_id']     = $asset->id;
                $vehicleData['nama_pemilik'] = $asset->pemegang_saat_ini;
                $vehicleData['jabatan']      = $asset->jabatan_pemegang;
                $vehicleData['alamat']       = $asset->alamat_pemegang;
                \App\Models\VehicleDetail::create($vehicleData);
            }
        }

        if ($request->filled('pemegang_saat_ini')) {
            AssetHistory::create([
                'asset_id'             => $asset->id,
                'dari_pemegang'        => null,
                'ke_pemegang'          => $request->pemegang_saat_ini,
                'jabatan_ke'           => $request->jabatan_pemegang,
                'nipp_ke'              => $request->nipp_pemegang,
                'tanggal_serah_terima' => now(),
                'nomor_ba'             => AssetHistory::generateNomorBA(),
                'keterangan'           => 'Penerimaan awal aset'
            ]);
        }

        return redirect()->route('assets.index')->with('success','Aset berhasil ditambahkan! Kode: '.$asset->kode_aset);
    }

    public function show(Asset $asset)
    {
        $asset->load(['histories', 'changeLogs']);
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $users = User::orderBy('name')->get();
        return view('assets.edit', compact('asset', 'users'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'kode_aset'        => 'nullable|unique:assets,kode_aset,'.$asset->id,
            'nama_aset'        => 'required',
            'kategori'         => 'required|in:Bangunan,Tanah,Kendaraan,Peralatan,Inventaris Barang dan Perabot Kantor',
            'merk'             => 'nullable','tipe'=>'nullable',
            'tahun_perolehan'  => 'required|integer',
            'nilai_perolehan'  => 'required|numeric',
            'kondisi'          => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi'           => 'required',
            'pemegang_saat_ini'=> 'nullable','keterangan'=>'nullable',
            'foto'             => 'nullable|image|max:2048'
        ]);

        if (empty($validated['kode_aset'])) unset($validated['kode_aset']);

        if ($request->hasFile('foto')) {
            if ($asset->foto) Storage::disk('public')->delete($asset->foto);
            $validated['foto'] = $request->file('foto')->store('assets','public');
        }

        // Tracking perubahan
        $tracked = \App\Models\Asset::$trackedFields;
        foreach ($tracked as $field => $label) {
            $oldVal = $asset->getOriginal($field);
            $newVal = $validated[$field] ?? $asset->$field;
            if ((string)$oldVal !== (string)$newVal) {
                \App\Models\AssetChangeLog::create([
                    'asset_id'    => $asset->id,
                    'field_name'  => $field,
                    'field_label' => $label,
                    'old_value'   => $oldVal,
                    'new_value'   => $newVal,
                    'changed_by'  => auth()->user()->name,
                ]);
            }
        }

        $asset->update($validated);
        return redirect()->route('assets.show', $asset)->with('success','Aset berhasil diupdate!');
    }

    public function destroy(Request $request, Asset $asset)
    {
        \DB::table('assets')->where('id',$asset->id)->update([
            'alasan_hapus' => $request->alasan_hapus ?? 'Dihapus oleh pengguna',
            'dihapus_oleh' => auth()->user()->name,
        ]);
        $asset->delete();
        return redirect()->route('assets.index')->with('success','Aset dipindahkan ke Aset Dihapus.');
    }

    // ===== TRASH / ASET DIHAPUS =====
    public function trash(Request $request)
    {
        $query = Asset::onlyTrashed();
        if ($request->filled('tipe'))     $query->where('tipe_dashboard', $request->tipe);
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('kode_aset','like',"%$s%")->orWhere('nama_aset','like',"%$s%"));
        }
        $assets = $query->latest('deleted_at')->paginate(15);
        return view('assets.trash', compact('assets'));
    }

    public function restore($id)
    {
        $asset = Asset::onlyTrashed()->findOrFail($id);
        $asset->restore();
        $asset->update(['alasan_hapus'=>null,'dihapus_oleh'=>null]);
        return back()->with('success','Aset '.$asset->nama_aset.' berhasil dipulihkan!');
    }

    public function forceDelete($id)
    {
        $asset = Asset::onlyTrashed()->findOrFail($id);
        if ($asset->foto) Storage::disk('public')->delete($asset->foto);
        if ($asset->qr_code) Storage::disk('public')->delete($asset->qr_code);
        $asset->forceDelete();
        return back()->with('success','Aset berhasil dihapus permanen.');
    }

    // ===== TRANSFER, STICKER, QR, dll =====
    public function transfer(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'ke_pemegang'          => 'required',
            'tanggal_serah_terima' => 'required|date',
            'jabatan_dari'         => 'nullable|string','jabatan_ke'=>'nullable|string',
            'nipp_dari'            => 'nullable|string','nipp_ke'=>'nullable|string',
            'keterangan'           => 'nullable'
        ]);

        $history = AssetHistory::create([
            'asset_id'             => $asset->id,
            'dari_pemegang'        => $asset->pemegang_saat_ini,
            'ke_pemegang'          => $validated['ke_pemegang'],
            'jabatan_dari'         => $validated['jabatan_dari'] ?? null,
            'jabatan_ke'           => $validated['jabatan_ke'] ?? null,
            'nipp_dari'            => $validated['nipp_dari'] ?? null,
            'nipp_ke'              => $validated['nipp_ke'] ?? null,
            'tanggal_serah_terima' => $validated['tanggal_serah_terima'],
            'nomor_ba'             => AssetHistory::generateNomorBA(),
            'keterangan'           => $validated['keterangan']
        ]);

        $asset->update(['pemegang_saat_ini' => $validated['ke_pemegang']]);
        return redirect()->route('assets.show',$asset)->with('success','Transfer berhasil! Nomor BA: '.$history->nomor_ba);
    }

    public function printSticker(Asset $asset)
    {
        return view('assets.sticker', compact('asset'));
    }

    public function qrRedirect($kode_aset)
    {
        $asset = Asset::where('kode_aset',$kode_aset)->firstOrFail();
        return $asset->kategori === 'Kendaraan'
            ? redirect()->route('vehicles.show', $asset)
            : redirect()->route('assets.show', $asset);
    }

    public function downloadBA(AssetHistory $history)
    {
        $asset    = $history->asset;
        $pdf      = \PDF::loadView('assets.berita-acara', compact('asset','history'));
        $filename = 'BA_'.str_replace('/','_',$history->nomor_ba).'.pdf';
        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $query = Asset::where('tipe_dashboard','aset');
        if ($request->filled('kategori')) $query->where('kategori',$request->kategori);
        if ($request->filled('kondisi'))  $query->where('kondisi',$request->kondisi);
        if ($request->filled('pemegang')) $query->where('pemegang_saat_ini',$request->pemegang);
        $assets   = $query->get();
        $filename = 'Data_Aset_'.date('Ymd_His').'.csv';
        $headers  = ['Content-Type'=>'text/csv','Content-Disposition'=>'attachment; filename="'.$filename.'"'];
        $callback = function() use ($assets) {
            $file = fopen('php://output','w');
            fputcsv($file,['Kode Aset','Nama Aset','Kategori','Merk','Tipe','Tahun Perolehan','Nilai Perolehan','Kondisi','Lokasi','Pemegang Saat Ini','Keterangan']);
            foreach ($assets as $a)
                fputcsv($file,[$a->kode_aset,$a->nama_aset,$a->kategori,$a->merk,$a->tipe,$a->tahun_perolehan,$a->nilai_perolehan,$a->kondisi,$a->lokasi,$a->pemegang_saat_ini,$a->keterangan]);
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}