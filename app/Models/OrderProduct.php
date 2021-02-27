<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $fillable = [
        'specifications',
        'status',
        'price',
        'quantity'
    ];

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'purchaseable');
    }
}
