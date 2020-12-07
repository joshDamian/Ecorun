<?php

namespace App\Models;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\HasProfilePhoto;

class Profile extends Model
{
    use HasFactory;
    use HasProfilePhoto;
    use StringManipulations;

    protected $fillable = [
        'name',
        'eco_tag',
        'description'
    ];

    public const TAG_SUFFIX = '@ecorun';

    protected $with = [
        //'followers'
    ];

    /**
    * The accessors to append to the model's array form.
    *
    * @var array
    */
    protected $appends = [
        'profile_photo_url',
    ];

    public function followers() {
        return $this->belongsToMany(Profile::class, 'profile_follower', 'profile_id', 'follower_id');
    }

    public function following() {
        return $this->belongsToMany(Profile::class, 'profile_follower', 'follower_id', 'profile_id');
    }

    public function slugData() {
        return [
            'name' => $this->name,
        ];
    }

    public function profileable() {
        return $this->morphTo();
    }

    public function isBusiness() {
        return $this->profileable instanceof Business;
    }

    public function feedbacks() {
        return $this->hasMany(Feedback::class);
    }

    public function isUser() {
        return $this->profileable instanceof User;
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }
}