<?php

namespace App\Models;

use App\Models\Traits\BelongsToClientProjectTrait;
use App\Models\Traits\TaskableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FixedFeeContract extends Model implements ContractableInterface
{
    use BelongsToClientProjectTrait, TaskableTrait;

    protected $fillable = [
        'client_project_id', 
        'harvest_id', 
        'name', 'code', 
        'total_price_te', 
        'delivered_at', 
        'warranty_days', 
        'active',
        'default_daily_rate'
    ];

    protected $casts = [
        'client_project_id' => 'integer',
        'harvest_id' => 'integer',
        'total_price_te' => 'float',
        'delivered_at' => 'datetime:Y-m-d',
        'active' => 'boolean',
        'default_daily_rate' => 'integer'
    ];

    protected $attributes = [
        'warranty_days' => 90,
        'active' => false,
        'default_daily_rate' => 600
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

    /**
     * Number of day to planned
     *
     * @return Attribute
     */
    protected function DayCount() : Attribute
    {
        return $this->default_daily_rate != 0 
            ? Attribute::make(
                get: fn($value, $attributes) => 
                    round(
                        $attributes['total_price_te'] / 
                        $attributes['default_daily_rate']
                    )
            )
            : Attribute::make( get: fn() => 0);
    }
}
