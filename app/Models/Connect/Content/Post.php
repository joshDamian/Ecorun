<?php

namespace App\Models\Connect\Content;

use App\Presenters\Post\AttachmentsPresenter;
use App\Presenters\Post\FollowersPresenter;
use App\Models\Connect\ContentFeedback\Feedback;
use App\Models\Connect\Profile\Profile;
use App\Presenters\Post\UrlPresenter;
use App\Traits\HasMediaAttachments;
use App\Traits\HasMentionsAndTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use App\Models\Connect\Content\Share;
use Rennokki\QueryCache\Traits\QueryCacheable;


class Post extends Model
{
    use HasFactory,
        QueryCacheable,
        HasMentionsAndTags,
        HasMediaAttachments,
        Searchable;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'url',
    ];

    protected $casts = [
        'mentions' => 'collection'
    ];

    protected $fillable = [
        'content',
        'visibility',
        'mentions',
    ];
    protected $attributes = [
        'mentions' => "[]"
    ];

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function comments()
    {
        return $this->morphMany(Feedback::class, 'feedbackable');
    }

    public static function boot()
    {
        parent::boot();
        self::saving(function ($model) {
            self::parseMentionsAndTags($model);
        });
        self::saved(function ($model) {
            self::syncWithTags($model);
        });
        self::created(function ($model) {
            //
        });

        self::deleted(function ($model) {
            $model->trash();
        });
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\Core\Media\Image', 'imageable');
    }

    public function getAttachmentsAttribute()
    {
        return (new AttachmentsPresenter($this));
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Connect\ContentFeedback\Like', 'likeable');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function trash(): void
    {
        Storage::disk('public')->delete($this->gallery->pluck('image_url')->toArray());
        $this->comments()->delete();
        $this->likes()->delete();
        $this->gallery()->delete();
        $this->shares()->delete();
        $this->attachments->all->each(function ($attachment) {
            $attachment->delete();
        });
    }

    public function shares()
    {
        return $this->morphMany(Share::class, 'shareable');
    }

    public function getFollowersAttribute()
    {
        return (new FollowersPresenter($this))->followers;
    }

    public function toSearchableArray(): array
    {
        return [
            'content' => $this->content,
        ];
    }

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
    }
}
