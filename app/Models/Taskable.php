<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Taskable extends MorphPivot
{
    protected $fillable = ['harvest_id', 'daily_rate', 'planned_days'];

    protected $casts = [
        'harvest_id'   => 'integer',
        'daily_rate'   => 'float',
        'planned_days' => 'float',
    ];

    protected $attributes = [
        'daily_rate'   => 0,
        'planned_days' => 0,
    ];
}
