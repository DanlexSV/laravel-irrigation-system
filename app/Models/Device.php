<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    protected $fillable = [
        'user_id',
        'mac_address',
		'floor_id',
		'water_frequency',
		'sunlight',
		'last_humidity',
        'last_measured_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

	public function floor(): BelongsTo
	{
		return $this->belongsTo(Floor::class);
	}

	public function humidityReadings(): HasMany
    {
        return $this->hasMany(HumidityReading::class);
    }

    public function latestReading(): HasOne
    {
        return $this->hasOne(HumidityReading::class)
                    ->latestOfMany('measured_at');
    }

	public function wateringEvents()
	{
		return $this->hasMany(WateringEvent::class);
	}

	public function latestWatering()
	{
		return $this->hasOne(WateringEvent::class)->latestOfMany('watered_at');
	}
}
