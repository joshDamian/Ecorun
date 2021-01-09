<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification as DbNotif;
use Rennokki\QueryCache\Traits\QueryCacheable;

class DatabaseNotification extends DbNotif
{
    use QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
}
