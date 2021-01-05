<?php

namespace App\Models;

use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Team extends JetstreamTeam
{
    use QueryCacheable;

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
