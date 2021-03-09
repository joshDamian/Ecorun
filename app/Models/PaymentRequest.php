<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class PaymentRequest extends Model
{
    use HasFactory, QueryCacheable;

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
