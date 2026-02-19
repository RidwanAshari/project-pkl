<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'tanggal',
        'jenis_servis',
        'jenis_bbm',
        'jumlah_liter',
        'harga_per_liter',
        'odometer',
        'keterangan',
        'bengkel',
        'biaya',
        'file_nota',
        'file_surat_pengantar',
        'is_acc_kabag' // ← tambahan untuk ACC Kabag
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_liter' => 'decimal:2',
        'harga_per_liter' => 'decimal:2',
        'biaya' => 'decimal:2',
        'is_acc_kabag' => 'boolean' // ← biar otomatis true/false
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
