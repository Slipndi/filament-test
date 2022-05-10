<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'code', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $attributes = [
        'active' => false,
    ];

    public function projects()
    {
        return $this->hasMany(ClientProject::class);
    }
}
