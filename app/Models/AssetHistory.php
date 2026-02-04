<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AssetHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'dari_pemegang',
        'ke_pemegang',
        'lokasi_lama',
        'lokasi_baru',
        'kondisi_lama',
        'kondisi_baru',
        'departemen_lama',
        'departemen_baru',
        'tanggal_serah_terima',
        'nomor_ba',
        'jenis_perubahan',
        'file_ba',
        'keterangan',
        'created_by'
    ];

    protected $casts = [
        'tanggal_serah_terima' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'creator_name',
        'formatted_tanggal',
        'status_badge',
        'nomor_ba_with_link'
    ];

    // ============================================
    // RELASI
    // ============================================

    /**
     * Relasi ke asset
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Relasi ke user yang membuat histori (created_by)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ============================================
    // ACCESSORS & MUTATORS
    // ============================================

    /**
     * Nama creator - via relasi user
     */
    protected function creatorName(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->relationLoaded('user') && $this->user) {
                    return $this->user->name;
                }
                
                if ($this->created_by) {
                    // Load user jika belum diload
                    $user = User::find($this->created_by);
                    return $user ? $user->name : "User #{$this->created_by}";
                }
                
                return 'System';
            }
        );
    }

    /**
     * Format tanggal serah terima
     */
    protected function formattedTanggal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tanggal_serah_terima 
                ? $this->tanggal_serah_terima->translatedFormat('d F Y H:i') 
                : '-'
        );
    }

    /**
     * Status badge untuk jenis perubahan
     */
    protected function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                $badges = [
                    'Penerimaan Awal' => 'badge bg-success',
                    'Transfer Pemegang' => 'badge bg-info',
                    'Perbaikan' => 'badge bg-warning',
                    'Penghapusan' => 'badge bg-danger',
                    'Pemeliharaan' => 'badge bg-primary',
                    'Mutasi' => 'badge bg-secondary',
                ];

                $class = $badges[$this->jenis_perubahan] ?? 'badge bg-light text-dark';
                return "<span class='{$class}'>{$this->jenis_perubahan}</span>";
            }
        );
    }

    /**
     * Format nomor BA dengan link
     */
    protected function nomorBaWithLink(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->nomor_ba) return '-';
                
                $url = route('assets.history.download-ba', $this->id);
                return "<a href='{$url}' class='text-primary' target='_blank' title='Download BA'>
                            <i class='fas fa-file-pdf'></i> {$this->nomor_ba}
                        </a>";
            }
        );
    }

    /**
     * Cek apakah asset adalah kendaraan
     */
    public function getIsKendaraanAttribute()
    {
        // Eager load asset jika belum
        if (!$this->relationLoaded('asset')) {
            $this->load('asset');
        }
        
        return $this->asset && $this->asset->kategori === 'Kendaraan';
    }

    /**
     * URL untuk detail kendaraan
     */
    public function getVehicleDetailUrlAttribute()
    {
        if (!$this->is_kendaraan) return null;
        return route('vehicles.show', ['vehicle' => $this->asset_id]);
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope untuk filter berdasarkan bulan
     */
    public function scopeBulanIni($query)
    {
        return $query->whereYear('tanggal_serah_terima', date('Y'))
                    ->whereMonth('tanggal_serah_terima', date('m'));
    }

    /**
     * Scope untuk filter berdasarkan jenis perubahan
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis_perubahan', $jenis);
    }

    /**
     * Scope untuk filter berdasarkan asset_id
     */
    public function scopeAssetId($query, $assetId)
    {
        return $query->where('asset_id', $assetId);
    }

    /**
     * Scope untuk histori dengan user
     */
    public function scopeWithUser($query)
    {
        return $query->with(['user' => function ($q) {
            $q->select('id', 'name', 'email');
        }]);
    }

    /**
     * Scope untuk histori dengan asset
     */
    public function scopeWithAsset($query)
    {
        return $query->with(['asset' => function ($q) {
            $q->select('id', 'kode_aset', 'nama_aset', 'kategori');
        }]);
    }

    // ============================================
    // METHOD STATIC generateNomorBA() - YANG DIPERBAIKI
    // ============================================

    /**
     * Method STATIC untuk menghasilkan Nomor BA (Bukti Serah Terima)
     * Format: BA-YYYYMMDD-001
     * 
     * @return string
     */
    public static function generateNomorBA(): string
    {
        $prefix = 'BA';
        $date = now()->format('Ymd'); // Format: 20240129
        
        // Cari nomor BA terakhir dengan format yang sama hari ini
        $lastBA = self::where('nomor_ba', 'LIKE', "{$prefix}-{$date}-%")
            ->orderBy('nomor_ba', 'desc')
            ->first();
        
        if ($lastBA && !empty($lastBA->nomor_ba)) {
            // Ekstrak nomor urut dari format BA-YYYYMMDD-001
            $parts = explode('-', $lastBA->nomor_ba);
            if (count($parts) >= 3) {
                $lastNumber = (int) $parts[2];
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }
        } else {
            $nextNumber = 1;
        }
        
        // Format: BA-20240129-001
        return sprintf("%s-%s-%03d", $prefix, $date, $nextNumber);
    }

    /**
     * Alternative: Method instance yang memanggil static method
     * Untuk kompatibilitas jika ada yang sudah memanggil sebagai instance
     */
    public function generateBA(): string
    {
        return self::generateNomorBA();
    }
}