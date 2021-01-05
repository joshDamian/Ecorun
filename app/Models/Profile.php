<?php

namespace App\Models;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Str;
use App\Tools\GeneratorTool;
use Illuminate\Notifications\Notifiable;
use App\Presenters\Profile\FeedPresenter;
use App\Presenters\Profile\UrlPresenter;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Profile extends Model
{
    use Notifiable,
        HasFactory,
        HasProfilePhoto,
        QueryCacheable,
        StringManipulations;

    protected $fillable = [
        'name',
        'tag',
        'description'
    ];

    public const TAG_PREFIX = '@';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'url'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function followers()
    {
        return $this->belongsToMany(Profile::class, 'profile_follower', 'profile_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class, 'profile_follower', 'follower_id', 'profile_id');
    }

    public function slugData()
    {
        return [
            'name' => $this->name,
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($profile) {
                $profile->auto_tag = (string) Str::uuid();
                $profile->tag = $profile->tag ?? GeneratorTool::generateID(Profile::class, 'tag', [], $profile->name . ".");
            }
        );
    }

    public function profileable()
    {
        return $this->morphTo();
    }

    public function isBusiness()
    {
        return $this->profileable instanceof Business;
    }

    public function full_tag()
    {
        return Profile::TAG_PREFIX . $this->tag;
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function getFeedAttribute()
    {
        return (new FeedPresenter($this));
    }

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
    }

    public function isUser()
    {
        return $this->profileable instanceof User;
    }

    public function getGalleryAttribute()
    {
        return $this->posts()->has('gallery')->get()->loadMissing('gallery');
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }
}
