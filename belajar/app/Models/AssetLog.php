<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetLog extends Model
{
    use HasFactory;

    // 1. Nama tabel (Opsional, karena Laravel otomatis tau namanya 'asset_logs')
    protected $table = 'asset_logs';

    // 2. Fillable (SANGAT PENTING)
    // Ini adalah kolom yang boleh diisi secara langsung (mass assignment)
    protected $fillable = [
        'asset_id',
        'user_name',
        'action',
        'date',
    ];

    // 3. Relasi (Opsional tapi disarankan)
    // Satu Log milik satu Aset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    // 4. Casting Format Tanggal (Opsional)
    protected $casts = [
        'date' => 'datetime',
    ];
}