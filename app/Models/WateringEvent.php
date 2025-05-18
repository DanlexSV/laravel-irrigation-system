<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WateringEvent extends Model
{
    protected $fillable = [
        'device_id',
        'watered_at',
        'duration_seconds',
        'source',
        'note',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
