<?php

namespace App\Models;

use App\Traits\HasMentionsAndTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Feedback\UrlPresenter;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Support\Facades\Storage;

class Feedback extends Model
{
    use HasFactory,
        QueryCacheable,
        HasMentionsAndTags;

    protected $fillable = [
        'content',
        'title',
    ];
    protected $casts = [
        'mentions' => 'collection'
    ];
    protected $attributes = [
        'mentions' => "[]"
    ];

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function parentIsPost()
    {
        return $this->feedbackable_type === Post::class;
    }

    public function parentIsFeedback()
    {
        return $this->feedbackable_type === Feedback::class;
    }

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
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
        self::deleting(function ($model) {
            Storage::disk('public')->delete($model->gallery->pluck('image_url')->toArray());
            $model->replies()->delete();
            $model->likes()->delete();
            $model->gallery()->delete();
        });
    }

    public function trash(): bool
    {
        Storage::disk('public')->delete($this->gallery->pluck('image_url')->toArray());
        $this->comments()->delete();
        $this->likes()->delete();
        $this->gallery()->delete();
        $this->delete();
        return true;
    }

    public function feedbackable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->morphMany('App\Models\Feedback', 'feedbackable');
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
}
