<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AssetMaintenance extends Model {
    protected $fillable = ['asset_id','tanggal','jenis_pemeliharaan','keterangan','biaya','vendor','file_nota'];
    public function asset() { return $this->belongsTo(Asset::class); }
}