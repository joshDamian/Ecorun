<?php

namespace App\Models;

use App\Presenters\Profile\ConversationsPresenter;
use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProfilePhoto;
use Illuminate\Support\Str;
use App\Tools\GeneratorTool;
use Illuminate\Notifications\Notifiable;
use App\Presenters\Profile\FeedPresenter;
use App\Presenters\Profile\UrlPresenter;
use Laravel\Scout\Searchable;
use Rennokki\QueryCache\Traits\QueryCacheable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class Profile extends Model
{
    use Notifiable,
        HasFactory,
        HasProfilePhoto,
        QueryCacheable,
        Searchable,
        /*HasPushSubscriptions , */
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
        'url',
        //'unread_messages_count',
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'tag' => $this->tag
        ];
    }

    public function direct_conversationWith(Profile $profile)
    {
        $pair = [
            $this->id,
            $profile->id
        ];
        $pair_reverse = [
            $profile->id,
            $this->id
        ];
        $conversations = $profile->conversations->directConversations;
        $pair_exists = $conversations->firstWhere('pair_ids', $pair) ?? $conversations->firstWhere('pair_ids', $pair_reverse);
        return $pair_exists;
    }

    public function followers()
    {
        return $this->belongsToMany(Profile::class, 'profile_follower', 'follower_id', 'profile_id')->withTimestamps();
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function owned_groups()
    {
        return $this->hasMany(GroupConversation::class, 'creator_id');
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class, 'profile_follower', 'profile_id', 'follower_id')->withTimestamps();
    }

    public function slugData()
    {
        return [
            'name' => $this->name,
        ];
    }

    /**
     *  Get all of the subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function getPushSubscriptionsAttribute()
    {
        if ($this->isUser()) {
            return $this->profileable->pushSubscriptions;
        }
        if ($this->isBusiness()) {
            $business = $this->profileable;
            $user_ids = $business->team->allUsers()->pluck('id');
            return app(config('webpush.model'))->whereIn('subscribable_id', $user_ids)->where('subscribable_type', User::class)->get();
        }
        return;
    }

    /**
     * Get all of the subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function routeNotificationForWebPush()
    {
        return $this->pushSubscriptions;
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(
            function ($profile) {
                $profile->auto_tag = (string) Str::uuid();
                $profile->tag = $profile->tag ?? GeneratorTool::generateID(Profile::class, 'tag', [], "auto-tag-");
            }
        );
        static::created(function ($profile) {
            if (Profile::where('tag', 'ecorun')->exists()) {
                $profile->following()->save(Profile::firstWhere('tag', 'ecorun'));
            }
        });
    }

    public function profileable()
    {
        return $this->morphTo();
    }

    public function isOnline()
    {
        return $this->profileable->isOnline();
    }

    public function getConversationsAttribute()
    {
        return (new ConversationsPresenter($this));
    }

    public function getUnreadMessagesCountAttribute()
    {
        return $this->conversations->all->map(function ($conv) {
            return $conv->getUnreadFor($this);
        })->sum();
    }

    public function isBusiness()
    {
        return $this->profileable_type === Business::class;
    }

    public function full_tag()
    {
        return Profile::TAG_PREFIX . $this->tag;
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function messages()
    {
        return $this->hasMany(
            Message::class,
            'sender_id'
        );
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
        return $this->profileable_type === User::class;
    }


    public function getGalleryAttribute()
    {
        return $this->posts()->has('gallery')->with('gallery')->get();
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
