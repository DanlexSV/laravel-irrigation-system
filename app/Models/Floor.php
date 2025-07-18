<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = [
        'name',
        'scientific_name',
        'family',
        'water_frequency',
        'sunlight',
        'care_notes',
    ];
}
