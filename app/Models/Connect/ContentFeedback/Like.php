<?php

namespace App\Models\Connect\ContentFeedback;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Like extends Model
{
    use HasFactory, QueryCacheable;

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function likeable()
    {
        return $this->morphTo();
    }
}
