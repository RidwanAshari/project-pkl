<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AssetDepreciation extends Model {
    protected $fillable = [
        "asset_id",
        "metode",
        "umur_ekonomis",
        "nilai_sisa",
        "tahun_mulai",
        "keterangan",
        "tarif_penyusutan",
    ];

    public function details() {
        return $this->hasMany(AssetDepreciationDetail::class, "asset_depreciation_id");
    }

    public function asset() {
        return $this->belongsTo(Asset::class);
    }
}
