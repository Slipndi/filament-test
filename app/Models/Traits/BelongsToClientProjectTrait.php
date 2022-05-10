<?php

namespace App\Models\Traits;

use App\Models\ClientProject;

trait BelongsToClientProjectTrait
{
    public function clientProject()
    {
        return $this->belongsTo(ClientProject::class);
    }
}
