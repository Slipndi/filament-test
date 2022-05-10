<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'harvest_id', 'timeable_type', 'timeable_id', 'date', 'hours', 'description'];

    protected $casts = [
        'user_id'     => 'integer',
        'harvest_id'  => 'integer',
        'timeable_id' => 'integer',
        'date'        => 'datetime:Y-m-d',
        'hours'       => 'float',
    ];

    protected $attributes = [
        'hours' => 0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function timeable()
    {
        return $this->morphTo();
    }
}
