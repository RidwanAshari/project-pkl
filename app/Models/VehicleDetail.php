<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'nama_pemilik',
        'jabatan',
        'alamat',
        'nomor_plat',
        'model',
        'tahun_pembuatan',
        'isi_silinder',
        'nomor_rangka',
        'nomor_mesin',
        'warna',
        'bahan_bakar',
        'warna_tnkb',
        'tahun_registrasi',
        'nomor_bpkb',
        'tanggal_berlaku',
        'bulan_berlaku',
        'tahun_berlaku',
        'berat',
        'sumbu',
        'penumpang'
    ];

    protected $casts = [
        'tanggal_berlaku' => 'date',
        'berat' => 'decimal:2'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}