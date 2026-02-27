<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleMaintenance extends Model
{
    protected $table = 'vehicle_maintenances';

    protected $fillable = [
        'asset_id',
        'tanggal',
        'jenis_servis',
        'keterangan',
        'biaya',
        'file_nota',
        'file_surat_pengantar',
        'is_acc_kabag'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_acc_kabag' => 'boolean',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
