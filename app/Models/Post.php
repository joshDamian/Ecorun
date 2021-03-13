<?php

namespace App\Models;

use App\Events\PostCreated;
use App\Presenters\Post\FollowersPresenter;
use App\Presenters\Post\UrlPresenter;
use App\Traits\HasMentionsAndTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use Rennokki\QueryCache\Traits\QueryCacheable;


class Post extends Model
{
    use HasFactory,
    QueryCacheable,
    HasMentionsAndTags,
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

    public function comments() {
        return $this->morphMany(Feedback::class, 'feedbackable');
    }

    public static function boot() {
        parent::boot();
        self::saving(function ($model) {
            self::parseMentionsAndTags($model);
        });
        self::saved(function ($model) {
            self::syncWithTags($model);
        });
        self::created(function($model) {
            //
        });

        self::deleting(function ($model) {
            Storage::disk('public')->delete($model->gallery->pluck('image_url')->toArray());
            $model->comments()->delete();
            $model->likes()->delete();
            $model->gallery()->delete();
            $model->shares()->delete();
        });
    }

    public function gallery() {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function likes() {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    public function profile() {
        return $this->belongsTo(Profile::class);
    }

    public function trash(): bool
    {
        Storage::disk('public')->delete($this->gallery->pluck('image_url')->toArray());
        $this->comments()->delete();
        $this->likes()->delete();
        $this->gallery()->delete();
        $this->shares()->delete();
        $this->delete();
        return true;
    }

    public function shares() {
        return $this->morphMany(Share::class, 'shareable');
    }

    public function getFollowersAttribute() {
        return (new FollowersPresenter($this))->followers;
    }

    public function toSearchableArray(): array
    {
        return [
            'content' => $this->content,
        ];
    }

    public function getUrlAttribute() {
        return (new UrlPresenter($this));
    }
}