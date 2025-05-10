<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'flight_id',
        'flight_class_id',
        'name',
        'email',
        'phone',
        'number_of_passengers',
        'promo_code_id',
        'payment_status',
        'subtotal',
        'grandtotal',
    ];

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(FlightClass::class, 'flight_class_id');
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function passengers(): HasMany
    {
        return $this->hasMany(TransactionPassenger::class);
    }
}
