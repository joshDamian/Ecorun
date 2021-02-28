<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Transaction extends Model
{
    use HasFactory, QueryCacheable;

    protected $fillable = [
        'status',
        'vendor_type',
        'vendor_id',
        'buyer_type',
        'buyer_id'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function vendor()
    {
        return $this->morphTo();
    }

    public function purchaseable()
    {
        return $this->morphTo();
    }

    public function payment()
    {
        return $this->belongsTo(PaymentRequest::class);
    }

    public function buyer()
    {
        return $this->morphTo();
    }
}
