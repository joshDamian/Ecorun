<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Service extends Model
{
    use HasFactory, QueryCacheable;

    protected $with = [
        //'working_days'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function business()
    {
        return $this->morphOne('App\Models\Business', 'businessable');
    }

    public function working_days()
    {
        return $this->hasMany(ServiceWorkingDay::class);
    }
}
