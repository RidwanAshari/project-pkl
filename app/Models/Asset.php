<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_aset', 'nama_aset', 'kategori', 'merk', 'tipe',
        'tahun_perolehan', 'nilai_perolehan', 'kondisi', 'lokasi',
        'pemegang_saat_ini', 'jabatan_pemegang', 'alamat_pemegang',
        'nipp_pemegang', 'keterangan', 'foto', 'qr_code',
        'tipe_dashboard', 'alasan_hapus', 'dihapus_oleh',
    ];

    // Field yang akan dilacak perubahannya
    public static array $trackedFields = [
        'kode_aset'         => 'Kode Aset',
        'nama_aset'         => 'Nama Aset',
        'kategori'          => 'Kategori',
        'merk'              => 'Merk',
        'tipe'              => 'Tipe',
        'tahun_perolehan'   => 'Tahun Perolehan',
        'nilai_perolehan'   => 'Nilai Perolehan',
        'kondisi'           => 'Kondisi',
        'lokasi'            => 'Lokasi',
        'pemegang_saat_ini' => 'Pemegang',
        'keterangan'        => 'Keterangan',
    ];

    public function histories()
    {
        return $this->hasMany(AssetHistory::class);
    }

    public function changeLogs()
    {
        return $this->hasMany(AssetChangeLog::class)->latest();
    }

    public function vehicleDetail()
    {
        return $this->hasOne(VehicleDetail::class);
    }

    public function vehicleMaintenances()
    {
        return $this->hasMany(VehicleMaintenance::class);
    }

    public function assetDetail()        { return $this->hasOne(AssetDetail::class); }
    public function depreciation()       { return $this->hasOne(AssetDepreciation::class); }
    public function assetMaintenances()  { return $this->hasMany(AssetMaintenance::class); }
}