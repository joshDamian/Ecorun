<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Order extends Model
{
    use HasFactory, QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'status',
        'tracking_id'
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($order) {
            $order->tracking_id = time() . auth()->user()->id . $order->id;
            $order->save();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->using(OrderProduct::class)->withPivot([
            'specifications', 'price', 'quantity', 'id', 'status'
        ])->as('orderRequest')->withTimestamps();
    }
}
