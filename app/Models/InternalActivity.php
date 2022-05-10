<?php

namespace App\Models;

use App\Models\Traits\TaskableTrait;
use Illuminate\Database\Eloquent\Model;

class InternalActivity extends Model implements ContractableInterface
{
    use TaskableTrait;

    protected $fillable = ['harvest_id', 'name', 'code', 'active'];

    protected $casts = [
        'harvest_id' => 'integer',
        'active'     => 'boolean',
    ];

    protected $attributes = [
        'active' => false,
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
