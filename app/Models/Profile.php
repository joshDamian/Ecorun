<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    protected $with = [
        'followers'
    ];

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function profileable()
    {
        return $this->morphTo();
    }

    public function isBusiness()
    {
        return $this->profileable instanceof Business;
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function isUser()
    {
        return $this->profileable instanceof User;
    }

    public function profile_image()
    {
        return $this->profileable->profile_photo_url;
    }

    public function name()
    {
        return $this->profileable->name;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
