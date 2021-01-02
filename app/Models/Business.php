<?php

namespace App\Models;

use App\Traits\HasProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Business extends Model
{
    use SoftDeletes, HasProfile, HasFactory, QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function businessable()
    {
        return $this->morphTo();
    }

    public function isStore()
    {
        return $this->businessable instanceof Store;
    }

    public function isService()
    {
        return $this->businessable instanceof Service;
    }

    public function products()
    {
        return $this->hasMany(Product::class)->where('is_published', true)->latest();
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function locations()
    {
        return $this->morphMany('App\Models\Location', 'locateable');
    }
}
