<?php

namespace App\Models;

use App\Traits\HasProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
//use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasProfile;
    use HasApiTokens;
    use HasFactory;
    //use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'email',
        'password',
    ];

    protected $with = [
        //'profile',
        //'currentProfile',
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

    public function isManager() {
        return $this->hasOne(Manager::class)->withDefault();
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function cart() {
        return $this->hasMany(Cart::class);
    }

    public function view_history() {
        return $this->hasMany(RecentlyViewed::class);
    }

    public function associatedProfiles(): Collection
    {
        $manager_access = $this->loadMissing('isManager')->isManager;
        $business_profiles = $manager_access->loadMissing('businesses.profile')->businesses->pluck('profile');
        $team_business_profiles = Profile::whereIn('id', $this->teams->pluck('business.profile.id'))->get();
        return $team_business_profiles->concat($business_profiles)->sortBy('tag');
    }

    protected static function boot() {
        parent::boot();
        static::created(
            function ($user) {
                $name = explode("@", $user->email)[0];
                $user->profile()->create(
                    [
                        'name' => $name,
                        'tag' => (is_object(Profile::where('tag', $name . "." . $user->id)->get()->first())) ? null : substr($name, 0, 15) . "." . $user->id,
                        'description' => "Hi, I am {$name }, I'm new here and i hope to make new friends soon.",
                    ]
                );
                $user->profile->following()->save($user->profile);
                $user->switchProfile($user->profile);
            }
        );
    }

    public function switchProfile($profile) {
        if (!$this->can('access', $profile)) {
            return false;
        }
        $this->forceFill(
            [
                'current_profile_id' => $profile->id,
            ]
        )->save();
        $this->setRelation('currentProfile', $profile);
        return true;
    }

    public function currentProfile() {
        return $this->belongsTo(Profile::class, 'current_profile_id')->withDefault();
    }

    public function revokeManager() {
        return $this->isManager->revoke();
    }
}