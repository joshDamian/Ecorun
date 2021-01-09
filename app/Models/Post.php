<?php

namespace App\Models;

use App\Events\PostCreated;
use App\Parsers\HashTagParser;
use App\Parsers\MentionParser;
use App\Parsers\ProfileMentionGenerator;
use App\Presenters\Post\UrlPresenter;
use App\Queues\MentionQueue;
use App\Queues\TagQueue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Mention\MentionExtension;
use League\CommonMark\HtmlRenderer;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Tags\HasTags;

class Post extends Model
{
    use HasFactory, QueryCacheable, HasTags, Searchable;

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
        'mentions'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function comments()
    {
        return $this->morphMany('App\Models\Feedback', 'feedbackable');
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
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

    public function getSafeHtmlAttribute()
    {
        $converter = new CommonMarkConverter(['allow_unsafe_links' => false]);
        return $converter->convertToHtml($this->html);
    }

    public static function boot()
    {
        parent::boot();
        self::saving(function ($post) {
            App::singleton('tagqueue', function () {
                return new TagQueue;
            });
            App::singleton('mentionqueue', function () {
                return new MentionQueue;
            });
            $environment = Environment::createCommonMarkEnvironment();
            $environment->addInlineParser(new HashTagParser());
            $environment->addInlineParser(new MentionParser());
            $parser = new DocParser($environment);
            $htmlRender = new HtmlRenderer($environment);
            $text = $parser->parse($post->content);
            $post->html = $htmlRender->renderBlock($text);
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
            'mentions' => $this->mentions
        ];
    }

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
    }
}
