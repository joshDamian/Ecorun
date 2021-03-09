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
    protected $with = [
        'transaction'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'specifications',
        'status',
        'price',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->transaction()->create([
                'vendor_id' => $model->product->business_id,
                'vendor_type' => get_class($model->product->business),
                'buyer_id' => $model->order->user_id,
                'buyer_type' => get_class($model->order->user),
            ]);
        });
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'purchaseable');
    }
}
