<?php

namespace App\Models;

use App\Presenters\User\AssociatedProfilesPresenter;
use App\Presenters\User\NotificationsPresenter;
use App\Traits\HasProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Rennokki\QueryCache\Traits\QueryCacheable;

class User extends Authenticatable
{
    use HasProfile, HasApiTokens, HasFactory, HasTeams, Notifiable, TwoFactorAuthenticatable, QueryCacheable;

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
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        //
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function isManager()
    {
        return $this->hasOne(Manager::class)->withDefault();
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
                        'tag' => (Profile::where('tag', $name . "-" . $user->id)->exists()) ? null : substr($name, 0, 25) . "-" . $user->id,
                        'description' => "Hi, I am {$name}, I'm new here and i hope to make new friends.",
                    ]
                );
                $user->switchProfile($user->profile);
            }
        );
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

    public function currentProfile()
    {
        return $this->belongsTo(Profile::class, 'current_profile_id')->withDefault([
            'name' => 'Guest',
        ]);
    }

    public function revokeManager()
    {
        return $this->isManager->revoke();
    }
}
