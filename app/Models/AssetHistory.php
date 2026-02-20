<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'dari_pemegang',
        'ke_pemegang',
        'jabatan_dari',   // jabatan pihak pertama (yang menyerahkan)
        'jabatan_ke',     // jabatan pihak kedua (yang menerima)
        'nipp_dari',      // NIPP pihak pertama
        'nipp_ke',        // NIPP pihak kedua
        'tanggal_serah_terima',
        'nomor_ba',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_serah_terima' => 'datetime',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public static function generateNomorBA()
    {
        $tahun  = date('Y');
        $bulan  = date('m');
        $count  = self::whereYear('created_at', $tahun)->count() + 1;
        $urutan = str_pad($count, 3, '0', STR_PAD_LEFT);
        return "690.{$urutan}/U/BA/AK/{$bulan}/{$tahun}";
    }
}