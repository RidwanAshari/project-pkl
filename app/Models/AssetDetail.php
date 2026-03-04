<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AssetDetail extends Model {
    protected $fillable = [
        'asset_id','luas_bangunan','jumlah_lantai','konstruksi','nomor_imb','tanggal_imb',
        'luas_tanah','nomor_sertifikat','tanggal_sertifikat','jenis_sertifikat','berlaku_sampai',
        'nomor_seri','spesifikasi','garansi_sampai','lokasi_detail','catatan'
    ];
    public function asset() { return $this->belongsTo(Asset::class); }
}