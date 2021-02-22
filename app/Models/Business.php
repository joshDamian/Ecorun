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

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'type'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function isOnline()
    {
        return $this->team->allUsers()->filter(function ($user) {
            return $user->isOnline();
        })->count() > 0;
    }

    public function isStore()
    {
        return $this->type === "store";
    }

    public function isService()
    {
        return $this->type === "service";
    }

    public function products()
    {
        return $this->hasMany(Product::class)->latest('updated_at');
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
