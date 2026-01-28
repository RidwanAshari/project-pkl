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
        'lokasi_lama',
        'lokasi_baru',
        'kondisi_lama',
        'kondisi_baru',
        'departemen_lama',
        'departemen_baru',
        'tanggal_serah_terima',
        'nomor_ba',
        'jenis_perubahan',
        'file_ba',
        'keterangan',
        'created_by'
    ];

    // Relasi ke asset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    // Relasi ke user yang membuat histori (created_by)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke user (jika ada relasi langsung)
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor untuk nama creator
    public function getCreatorNameAttribute()
    {
        if ($this->created_by) {
            $user = User::find($this->created_by);
            return $user ? $user->name : "User #{$this->created_by}";
        }
        return 'System';
    }

    // Method untuk generate nomor BA
    public static function generateNomorBA()
    {
        $month = date('m');
        $year = date('Y');
        $count = self::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count() + 1;
        
        return "BA/{$month}/{$year}/" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}