<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'number',
        'total_te',
        'total_ti',
        'balance',
        'issued_on',
        'note',
        'frozen',
    ];

    protected $casts = [
        'client_id' => 'integer',
        'total_te'  => 'decimal:2',
        'total_ti'  => 'decimal:2',
        'balance'   => 'decimal:2',
        'issued_on' => 'date',
        'frozen'    => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
