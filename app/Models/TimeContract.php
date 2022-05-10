<?php

namespace App\Models;

use App\Models\Traits\BelongsToClientProjectTrait;
use App\Models\Traits\TaskableTrait;
use Illuminate\Database\Eloquent\Model;

class TimeContract extends Model implements ContractableInterface
{
    use BelongsToClientProjectTrait, TaskableTrait;

    protected $fillable = ['client_project_id', 'harvest_id', 'name', 'code', 'default_daily_rate', 'minimum_billable_hours', 'started_at', 'ended_at', 'active'];

    protected $casts = [
        'client_project_id'      => 'integer',
        'harvest_id'             => 'integer',
        'minimum_billable_hours' => 'integer',
        'default_daily_rate'     => 'float',
        'started_at'             => 'datetime:Y-m-d',
        'ended_at'               => 'datetime:Y-m-d',
        'active'                 => 'boolean',
    ];

    protected $attributes = [
        'minimum_billable_hours' => 0,
        'active'                 => false,
    ];

    public function times()
    {
        // See App/Providers/AppServiceProvider::boot() call to Relation::morphMap()
        return $this->morphMany(TimeEntry::class, 'timeable');
    }

    public function getType()
    {
        return mb_substr(mb_strrchr(__CLASS__, '\\'), 1);
    }
}
