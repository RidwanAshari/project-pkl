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
        'tanggal_serah_terima',
        'nomor_ba',
        'file_ba',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_serah_terima' => 'date'
    ];

    // Relasi ke asset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    // Generate nomor BA otomatis
    public static function generateNomorBA()
    {
        $year = date('Y');
        $month = date('m');
        
        $lastBA = self::whereYear('created_at', $year)
                      ->whereMonth('created_at', $month)
                      ->latest()
                      ->first();
        
        $number = $lastBA ? (int)substr($lastBA->nomor_ba, -4) + 1 : 1;
        
        return sprintf('BA/%s/%s/%04d', $month, $year, $number);
    }
}