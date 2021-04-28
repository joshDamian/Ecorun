<?php

namespace App\Models\Information\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Contact extends Model
{
    use HasFactory, QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'phone'
    ];

    public function contactable()
    {
        return $this->morphTo();
    }
}
