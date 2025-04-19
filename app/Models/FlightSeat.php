<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlightSeat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'flight_id',
        'name',
        'row',
        'column',
        'class_type',
        'is_available',
    ];

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }

    public function passenger(): HasOne
    {
        return $this->hasOne(TransactionPassenger::class);
    }
}
