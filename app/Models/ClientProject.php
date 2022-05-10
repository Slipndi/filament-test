<?php

namespace App\Models;

use App\Planning\Models\PlanningEntry;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class ClientProject extends Model
{
    public $urlAttrs = [
        'prod_url',
        'staging_url',
        'repository_url',
    ];

    protected $fillable = [
        'name',
        'code',
        'url',
        'active',
    ];

    protected $visible = [
        'name',
        'code',
        'prod_url',
        'staging_url',
        'repository_url',
        'tags_array',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $attributes = [
        'active' => false,
    ];

    protected $appends = [
        'tags_array',
    ];

    public function getTagsArrayAttribute()
    {
        if (! empty($this->tags)) {
            return explode(',', $this->tags);
        }

        return [];
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function fixedFeeContracts() : HasMany
    {
        return $this->hasMany(FixedFeeContract::class);
    }

    public function timeContracts() : HasMany
    {
        return $this->hasMany(TimeContract::class);
    }

    public function PlanningEntries() : hasMany 
    {
        return $this->hasMany(PlanningEntry::class, 'project_id');
    }

    public function getTotalTimeEntriesThisMonth() : int
    {
        $timeEntriesThisMonth = PlanningEntry::where('project_id', $this->id)
            ->whereBetween('date', [
                new Carbon('first day of this month'), 
                new Carbon('first day of +1 month')])
            ->selectRaw('sum(TIME_TO_SEC(duration) / 3600) as hours')
            ->first()
            ->hours; 
            
        return $timeEntriesThisMonth ?: 0; 
    }
    
    public function getTotalTimeEntries() : int
    {
        $timeEntries = PlanningEntry::where('project_id', $this->id)
            ->selectRaw('sum(TIME_TO_SEC(duration) / 3600) as hours')
            ->first()
            ->hours; 

        return $timeEntries ?: 0;
    }
    
}
