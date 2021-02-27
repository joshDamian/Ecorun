<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

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
            $order->products->each(function ($item) use ($order) {
                $item->order_request->transaction()->save((new Transaction())->forceFill([
                    'vendor_id' => $item->business_id,
                    'vendor_type' => get_class($item->business),
                    'buyer_id' => $order->user_id,
                    'buyer_type' => get_class($order->user),
                ]));
            });
        });
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->using(OrderProduct::class)->withPivot([
            'specifications', 'price', 'quantity'
        ])->withTimestamps();
    }
}
