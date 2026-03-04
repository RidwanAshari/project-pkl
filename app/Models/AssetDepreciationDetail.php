<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AssetDepreciationDetail extends Model {
    protected $fillable = [
        "asset_depreciation_id",
        "tahun",
        "bulan",
        "nilai_awal",
        "beban_penyusutan",
        "akumulasi_penyusutan",
        "nilai_buku",
    ];

    public function depreciation() {
        return $this->belongsTo(AssetDepreciation::class, "asset_depreciation_id");
    }
}
