<?php

namespace App\Models\Build\Business;

use App\Models\Build\Sellable\Sellable;
use App\Models\Connect\Profile\Badge;
use App\Traits\HasBadges;
use App\Models\Team;
use App\Presenters\Business\UrlPresenter;
use App\Traits\HasProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Business extends Model
{
    use SoftDeletes,
        HasProfile,
        HasFactory,
        QueryCacheable,
        HasBadges;

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'primary_badge_id'
    ];
    protected $appends = [
        'url'
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            $model->profile->delete();
            $model->warehouse->delete();
            $model->team->delete();
        });
    }

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

    public function warehouse()
    {
        return $this->morphMany(Sellable::class, 'vendor')->latest('updated_at');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'vendor')->latest('updated_at');
    }

    public function orders()
    {
        return $this->transactions()->where('purchaseable_type', OrderProduct::class);
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function locations()
    {
        return $this->morphMany('App\Models\Location', 'locateable');
    }

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
    }

    public function getDefaultBadge()
    {
        return Badge::firstWhere(function ($query) {
            $query->where('label', 'business')->where('canuse', 'business');
        }) ?? Badge::forceCreate([
            'label' => 'business',
            'description' => 'a business on ecorun',
            'canuse' => 'business',
            'credit' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function getBadgeCanUse()
    {
        return 'business';
    }
}
