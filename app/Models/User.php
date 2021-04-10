<?php

namespace App\Models;

use App\Presenters\User\AssociatedProfilesPresenter;
use App\Presenters\User\NotificationsPresenter;
use App\Presenters\User\UrlPresenter;
use App\Traits\HasBadges;
use App\Traits\HasProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Rennokki\QueryCache\Traits\QueryCacheable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasProfile,
        HasApiTokens,
        HasFactory,
        HasTeams,
        Notifiable,
        TwoFactorAuthenticatable,
        HasPushSubscriptions,
        HasBadges,
        QueryCacheable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_business_owner' => 'boolean'
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        //'unread_messages_count'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function view_history()
    {
        return $this->hasMany(RecentlyViewed::class);
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function getAssociatedProfilesAttribute()
    {
        return (new AssociatedProfilesPresenter($this));
    }

    public function getCustomNotificationsAttribute()
    {
        return (new NotificationsPresenter($this));
    }

    protected static function boot()
    {
        parent::boot();
        static::created(
            function ($user) {
                $name = explode("@", $user->email)[0];
                $user->profile()->create(
                    [
                        'name' => $name,
                        'tag' => (Profile::where('tag', "auto-tag-" . $user->id)->exists()) ? null : "auto-tag-" . $user->id,
                        'description' => "Hi, I am {$name}, I'm new here and I hope to make new friends.",
                    ]
                );
                $user->switchProfile($user->profile);
            }
        );
    }

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
    }

    public function switchProfile($profile)
    {
        if (!$this->can('access', $profile)) {
            return false;
        }
        $this->forceFill(['current_profile_id' => $profile->id])->save();
        $this->setRelation('currentProfile', $profile);
        return $profile->save();
    }

    public function getUnreadMessagesCountAttribute()
    {
        return $this->associated_profiles->all->map(function ($profile) {
            return $profile->unread_messages_count;
        })->sum();
    }

    public function currentProfile()
    {
        return $this->belongsTo(Profile::class, 'current_profile_id')->withDefault([
            'name' => 'Guest',
        ]);
    }

    public function getDefaultBadge()
    {
        return Badge::firstWhere(function ($query) {
            $query->where('label', 'eco-regular')->where('canuse', 'user');
        });
    }

    public function getBadgeCanUse()
    {
        return 'user';
    }
}
