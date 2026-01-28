<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'dari_pemegang',
        'ke_pemegang',
        'departemen_lama',
        'departemen_baru',
        'lokasi_lama',
        'lokasi_baru',
        'kondisi_lama',
        'kondisi_baru',
        'tanggal_serah_terima',
        'nomor_ba',
        'jenis_perubahan',
        'keterangan',
        'created_by' // Ini adalah foreign key ke users
    ];

    protected $casts = [
        'tanggal_serah_terima' => 'datetime',
    ];

    // Relasi ke asset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    // Relasi ke user yang membuat histori (created_by)
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Generate nomor BA otomatis - VERSI LEBIH AMAN
    public static function generateNomorBA()
    {
        $year = date('Y');
        $month = date('m');
        
        // Cari nomor BA terakhir bulan ini
        $lastBA = self::whereYear('created_at', $year)
                      ->whereMonth('created_at', $month)
                      ->orderBy('id', 'desc')
                      ->first();
        
        if ($lastBA && $lastBA->nomor_ba) {
            try {
                // Ekstrak angka dari nomor BA terakhir
                $parts = explode('/', $lastBA->nomor_ba);
                $lastNumber = (int) end($parts);
                $number = $lastNumber + 1;
            } catch (\Exception $e) {
                // Jika format tidak sesuai, mulai dari 1
                $number = 1;
            }
        } else {
            $number = 1;
        }
        
        return sprintf('BA/%s/%s/%04d', $month, $year, $number);
    }
    
    // Method untuk mengambil nama pembuat (dengan fallback)
    public function getCreatedByNameAttribute()
    {
        if ($this->user) {
            return $this->user->name;
        }
        
        if ($this->created_by) {
            // Coba load user jika belum diload
            $user = User::find($this->created_by);
            if ($user) {
                return $user->name;
            }
            return "User #{$this->created_by}";
        }
        
        return 'System';
    }
    
    // Boot method untuk set created_by otomatis
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->nomor_ba)) {
                $model->nomor_ba = self::generateNomorBA();
            }
            
            if (empty($model->created_by) && auth()->check()) {
                $model->created_by = auth()->id();
            }
        });
    }
}