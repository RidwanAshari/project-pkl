<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id', 'tanggal', 'jenis_servis', 'jenis_bbm',
        'jumlah_liter', 'harga_per_liter', 'odometer', 'keterangan',
        'bengkel', 'biaya', 'file_nota', 'file_surat_pengantar',
        'status_surat', 'file_surat_ttd',
        'biaya_aktual', 'file_nota_bengkel', 'terkirim_ke_finance',
        'approved_at', 'approved_by',
        'approved_at_eko', 'approved_by_eko', 'file_surat_ttd_eko',
    ];

    protected $casts = [
        'tanggal'             => 'date',
        'jumlah_liter'        => 'decimal:2',
        'harga_per_liter'     => 'decimal:2',
        'biaya'               => 'decimal:2',
        'approved_at'         => 'datetime',
        'approved_at_eko'     => 'datetime',
        'terkirim_ke_finance' => 'boolean',
    ];

    public function dpbDocument()
    {
        return $this->hasOne(DpbDocument::class, 'maintenance_id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}