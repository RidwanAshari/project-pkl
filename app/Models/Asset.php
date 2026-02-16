<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_aset',
        'tipe_dashboard',   // <-- TAMBAHAN BARU
        'nama_aset',
        'kategori',
        'merk',
        'tipe',
        'tahun_perolehan',
        'nilai_perolehan',
        'kondisi',
        'lokasi',
        'pemegang_saat_ini',
        'keterangan',
        'foto',
        'qr_code'
    ];

    protected $casts = [
        'tahun_perolehan' => 'integer',
        'nilai_perolehan' => 'decimal:2',
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime'
    ];

    public function histories()
    {
        return $this->hasMany(AssetHistory::class);
    }

    public function latestHistory()
    {
        return $this->hasOne(AssetHistory::class)->latest();
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