<?php

namespace App\Models\Traits;

use App\Models\Task;
use App\Models\Taskable;

trait TaskableTrait
{
    public function tasks()
    {
        return $this->morphToMany(Task::class, 'taskable')
            ->using(Taskable::class)
            ->withPivot('harvest_id', 'daily_rate', 'planned_days');
    }
}
