<?php

namespace App\Models;

use App\Actions\Ecorun\Post\ExtractMentionsAndTags;
use App\Events\PostCreated;
use App\Presenters\Post\UrlPresenter;
use App\Queues\MentionQueue;
use App\Queues\TagQueue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use League\CommonMark\CommonMarkConverter;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Tags\HasTags;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends Model
{
    use HasFactory,
    QueryCacheable,
    HasTags,
    Searchable;

    /**
    * The event map for the model.
    *
    * @var array
    */
    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];

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
        return $this->morphMany('App\Models\Feedback', 'feedbackable');
    }

    public static function getTagClassName(): string
    {
        return Tag::class;
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

    public function getSafeHtmlAttribute() {
        $converter = new CommonMarkConverter(['allow_unsafe_links' => false]);
        return $converter->convertToHtml($this->html);
    }

    public static function boot() {
        parent::boot();
        self::saving(function ($post) {
            App::singleton('tagqueue', function () {
                return new TagQueue;
            });
            App::singleton('mentionqueue', function () {
                return new MentionQueue;
            });
            $post->html = (new ExtractMentionsAndTags($post))->act();
            $post->mentions = app('mentionqueue')->getMentions();
        });
        self::saved(function ($post) {
            $post->syncTags(app('tagqueue')->getTags());
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'content' => $this->content,
        ];
    }

    public function tags(): MorphToMany
    {
        return $this
        ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
        ->orderBy('order_column');
    }

    public function getUrlAttribute() {
        return (new UrlPresenter($this));
    }
}