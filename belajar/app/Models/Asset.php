<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara mass assignment
    protected $fillable = [
        'code',
        'name',
        'category',
        'purchase_date',
        'price',
        'status',
        'photo',
    ];

    // Opsional: Casting otomatis tipe data
    protected $casts = [
        'purchase_date' => 'date',
        'price' => 'decimal:2',
    ];
}