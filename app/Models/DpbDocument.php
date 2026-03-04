<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DpbDocument extends Model
{
    protected $fillable = [
        'maintenance_id', 'nomor_dpb', 'tanggal_dpb',
        'total_biaya', 'total_pph', 'uraian', 'uraian_items',
        'nama_bengkel', 'untuk_keterangan',
        'dibuat_oleh', 'status',
        'status_eko', 'approved_by_eko', 'approved_at_eko',
    ];

    protected $casts = [
        'uraian_items'   => 'array',
        'approved_at_eko'=> 'datetime',
        'tanggal_dpb'    => 'date',
    ];

    public function maintenance()
    {
        return $this->belongsTo(VehicleMaintenance::class, 'maintenance_id');
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(\App\Models\User::class, 'dibuat_oleh');
    }
}