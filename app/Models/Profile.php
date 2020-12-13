<?php

namespace App\Models;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Str;

class Profile extends Model
{
    use HasFactory;
    use HasProfilePhoto;
    use StringManipulations;

    protected $fillable = [
        'name',
        'tag',
        'description'
    ];

    public const TAG_PREFIX = '@';

    protected $with = [
        'posts'
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

    /**
    * Get the profile's tag.
    *
    * @param  string  $value
    * @return string
    */
    public function getTagAttribute($value) {
        return $value ?? $this->initial_tag;
    }

    public function following() {
        return $this->belongsToMany(Profile::class, 'profile_follower', 'follower_id', 'profile_id');
    }

    public function slugData() {
        return [
            'name' => $this->name,
        ];
    }

    protected static function boot() {
        parent::boot();

        static::creating(function ($profile) {
            $profile->initial_tag = (string) Str::uuid();
        });
    }

    public function profileable() {
        return $this->morphTo();
    }

    public function isBusiness() {
        return $this->profileable instanceof Business;
    }

    public function full_tag() {
        return Profile::TAG_PREFIX . $this->tag;
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