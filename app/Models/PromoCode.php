<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'discount_type',
        'valid_until',
        'is_used',
    ];

    public function transactions(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }
}
