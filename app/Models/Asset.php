<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'kategori',
        'merk',
        'tipe',
        'tahun_perolehan',
        'nilai_perolehan',
        'kondisi',
        'lokasi',
        'pemegang_saat_ini',
        'jabatan_pemegang',   // untuk berita acara penerimaan awal
        'alamat_pemegang',    // untuk berita acara penerimaan awal
        'nipp_pemegang',      // untuk berita acara penerimaan awal
        'keterangan',
        'foto',
        'qr_code',
        'tipe_dashboard',
    ];

    public function histories()
    {
        return $this->hasMany(AssetHistory::class);
    }

    public function vehicleDetail()
    {
        return $this->hasOne(VehicleDetail::class);
    }

    public function vehicleMaintenances()
    {
        return $this->hasMany(VehicleMaintenance::class);
    }
}