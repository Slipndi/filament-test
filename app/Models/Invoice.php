<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'number',
        'total_te',
        'total_ti',
        'balance',
        'issued_on',
        'due_on',
        'payed_on',
        'note',
        'frozen',
    ];

    protected $casts = [
        'client_id' => 'integer',
        'total_te'  => 'decimal:2',
        'total_ti'  => 'decimal:2',
        'balance'   => 'decimal:2',
        'issued_on' => 'date',
        'due_on'    => 'date',
        'payed_on'  => 'date',
        'frozen'    => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getPaymentDaysAttribute()
    {
        if (is_null($this->payed_on)) {
            return null;
        }

        return $this->payed_on->diffInDays($this->issued_on);
    }

    public function getPaymentLateDaysAttribute()
    {
        if (! is_null($this->payed_on)) {
            return 0;
        }

        $now = Carbon::now();
        if ($this->due_on >= $now) {
            return null;
        }

        return $now->diffInDays($this->due_on);
    }
}
