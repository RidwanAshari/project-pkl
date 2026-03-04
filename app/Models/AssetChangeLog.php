<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetChangeLog extends Model
{
    protected $fillable = [
        'asset_id', 'field_name', 'field_label',
        'old_value', 'new_value', 'changed_by',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}