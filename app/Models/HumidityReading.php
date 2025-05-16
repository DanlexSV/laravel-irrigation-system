<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HumidityReading extends Model
{
    protected $table = 'humidity_readings';
	public $timestamps = false;

    protected $fillable = [
        'device_id',
        'humidity',
        'measured_at',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
