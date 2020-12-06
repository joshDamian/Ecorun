<?php

namespace App\Models;

use App\Traits\HasProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasProfile;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    protected $with = [
        //'following'
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

    public function isManager()
    {
        return $this->hasOne(Manager::class);
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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $name = explode("@", $user->email)[0] . '-' . $user->id;
            $user->profile()->create([
                'name' => $name,
                'eco_tag' => "{$name}@ecorun",
                'description' => "I am {$name}, I'm a newbie and i hope to make new friends soon.",
            ]);
            $user->profile->following()->save($user->profile);

            $user->switchProfile($user->profile);
        });
    }

    public function canAccessProfile(Profile $profile)
    {
        if ($profile->isBusiness()) {
            return $this->teams->pluck('business')->contains($profile->profileable) || ($this->isManager) ? $this->isManager->id === $profile->profileable->manager_id : false;
        } else {
            return $this->can('update', $profile);
        }
    }

    public function switchProfile($profile)
    {
        if (!$this->canAccessProfile($profile)) {
            return false;
        }

        $this->forceFill([
            'current_profile_id' => $profile->id,
        ])->save();

        $this->setRelation('currentProfile', $profile);

        return true;
    }

    public function revokeManager()
    {
        return $this->isManager->revoke();
    }
}
