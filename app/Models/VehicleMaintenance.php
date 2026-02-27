<?php

// app/Models/VehicleMaintenance.php

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
        'is_acc_kabag',
        'nota', // Menambahkan kolom nota
        'dpb_status' // Menambahkan kolom dpb_status
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_liter' => 'decimal:2',
        'harga_per_liter' => 'decimal:2',
        'biaya' => 'decimal:2',
        'is_acc_kabag' => 'boolean', // Untuk ACC Kabag
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    // Method untuk memperbarui status DPB
    public function updateDpbStatus($status)
    {
        $this->dpb_status = $status;
        $this->save();
    }

    // Validasi nota untuk memastikan ada minimal 1 item
    public function isNotaValid()
    {
        $nota = json_decode($this->nota, true);
        return isset($nota['items']) && count($nota['items']) >= 1;
    }

    // Accessor untuk mendapatkan status notifikasi berdasarkan tanggal jatuh tempo pajak (misalnya)
    public function getTaxNotificationStatusAttribute()
    {
        $dueDate = Carbon::parse($this->tax_due_date); // Pastikan field tax_due_date ada
        $now = Carbon::now();

        // Jika sudah lewat tempo
        if ($dueDate->isPast()) {
            return 'overdue'; // Badge merah
        }

        // Jika dalam 30 hari
        if ($dueDate->diffInDays($now) <= 30) {
            return 'approaching'; // Badge kuning
        }

        return 'ok'; // Tidak perlu notifikasi
    }
}