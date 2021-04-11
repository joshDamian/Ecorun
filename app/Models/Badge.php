<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Badge extends Model
{
    use HasFactory, QueryCacheable;

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'label', 'description', 'credit', 'icon', 'canuse'
    ];

    public function users()
    {
        return $this->morphedByMany('App\Models\User', 'badgable');
    }

    public function businesses()
    {
        return $this->morphedByMany('App\Models\Business', 'badgable');
    }

    public function creditProfile()
    {
        return $this->belongsTo('App\Models\Profile', 'credit');
    }
}
