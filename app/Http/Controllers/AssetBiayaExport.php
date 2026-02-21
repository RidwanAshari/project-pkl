<?php

namespace App\Exports;

use App\Models\Asset;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsBiayaExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Asset::query()
            ->where('tipe_dashboard', 'biaya'); // sesuaikan kolom/value

        if ($this->request->filled('kategori')) {
            $query->where('kategori', $this->request->kategori);
        }

        if ($this->request->filled('kondisi')) {
            $query->where('kondisi', $this->request->kondisi);
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_aset', 'like', "%{$search}%")
                  ->orWhere('nama_aset', 'like', "%{$search}%")
                  ->orWhere('pemegang_saat_ini', 'like', "%{$search}%");
            });
        }

        return $query->get([
            'kode_aset',
            'nama_aset',
            'kategori',
            'tahun_perolehan',
            'nilai_perolehan',
            'kondisi',
            'lokasi',
            'pemegang_saat_ini',
        ]);
    }

    public function headings(): array
    {
        return [
            'Kode Aset',
            'Nama Aset',
            'Kategori',
            'Tahun Perolehan',
            'Nilai Perolehan',
            'Kondisi',
            'Lokasi',
            'Pemegang Saat Ini',
        ];
    }
}
