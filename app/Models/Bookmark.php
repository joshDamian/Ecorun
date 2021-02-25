<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Bookmark\UrlPresenter;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Bookmark extends Model
{
    use HasFactory, QueryCacheable;

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function bookmarkable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
    }
}
