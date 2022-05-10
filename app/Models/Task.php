<?php


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name'];

    public function fixedFeeContracts()
    {
        return $this->morphedByMany(FixedFeeContract::class, 'taskable');
    }

    public function timeContracts()
    {
        return $this->morphedByMany(TimeContract::class, 'taskable');
    }

    public function internalActivities()
    {
        return $this->morphedByMany(InternalActivity::class, 'taskable');
    }
}
