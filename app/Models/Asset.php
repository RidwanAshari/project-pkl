<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Asset extends Model
{
    use HasFactory, LogsActivity; // <-- TAMBAHKAN LogsActivity disini

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
        'keterangan',
        'foto',
        'qr_code'
    ];

    protected $casts = [
        'tahun_perolehan' => 'integer',
        'nilai_perolehan' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Tambahkan method ini untuk konfigurasi activity log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['kode_aset', 'nama_aset', 'kategori', 'kondisi', 'lokasi', 'pemegang_saat_ini', 'nilai_perolehan'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Aset {$this->nama_aset} telah {$eventName}");
    }

    // Relasi ke histori pemegang
    public function histories()
    {
        return $this->hasMany(AssetHistory::class);
    }

    // Get histori terakhir
    public function latestHistory()
    {
        return $this->hasOne(AssetHistory::class)->latest();
    }

    // Relasi ke vehicle detail (hanya untuk kategori Kendaraan)
    public function vehicleDetail()
    {
        return $this->hasOne(VehicleDetail::class);
    }

    // Relasi ke vehicle maintenances
    public function vehicleMaintenances()
    {
        return $this->hasMany(VehicleMaintenance::class);
    }
}