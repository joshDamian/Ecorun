<?php

namespace App\Models\ReachingOut;

use Illuminate\Notifications\DatabaseNotification as Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class DatabaseNotification extends Model
{
    use QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
}
