<?php

namespace App\Models\Connect\ContentFeedback;

use App\Traits\HasMentionsAndTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Connect\Content\Post;
use App\Presenters\Feedback\UrlPresenter;
use App\Models\Connect\Profile\Profile;
use Rennokki\QueryCache\Traits\QueryCacheable;
use App\Events\FeedbackEvents\CommentedOnPost;
use App\Events\FeedbackEvents\RepliedToComment;
use App\Models\Core\Media\Image;

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
        self::created(function ($model) {
            if ($model->feedbackable_type === Post::class) {
                try {
                    broadcast(new CommentedOnPost($model))->toOthers();
                } catch (\Throwable $th) {
                    report($th);
                }
            } elseif ($model->feedbackable_type === Feedback::class) {
                try {
                    broadcast(new RepliedToComment($model))->toOthers();
                } catch (\Throwable $th) {
                    report($th);
                }
            }
        });
        self::deleted(function ($model) {
            $model->trash();
        });
    }

    public function trash(): void
    {
        $this->replies()->delete();
        $this->likes()->delete();
        $this->gallery()->delete();
    }

    public function feedbackable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->morphMany(Feedback::class, 'feedbackable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function gallery()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
