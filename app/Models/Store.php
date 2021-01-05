<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Store extends Model
{
    use HasFactory, QueryCacheable;

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function business()
    {
        return $this->morphOne('App\Models\Business', 'businessable');
    }
}
