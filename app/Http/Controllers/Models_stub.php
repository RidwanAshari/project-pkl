<?php
// ============================
// File: app/Models/AssetDepreciation.php
// ============================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetDepreciation extends Model
{
    protected $fillable = [
        'asset_id', 'metode', 'umur_ekonomis', 'nilai_sisa',
        'tarif_penyusutan', 'tahun_mulai', 'keterangan'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function details()
    {
        return $this->hasMany(AssetDepreciationDetail::class, 'asset_id', 'asset_id');
    }
}
