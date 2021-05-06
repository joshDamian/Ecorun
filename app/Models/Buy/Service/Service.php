<?php

namespace App\Models\Buy\Service;

use App\Models\Core\Media\Image;
use App\Models\Information\Basic\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Presenters\Service\UrlPresenter;
use App\Models\Core\DataSorting\Tag;
use App\Models\Connect\Content\Share;
use App\Models\Connect\ContentFeedback\Like;
use Laravel\Scout\Searchable;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Tags\HasTags;
use App\Models\Build\Sellable\Sellable;


class Service extends Model
{
    use HasFactory, SoftDeletes, QueryCacheable, HasTags, Searchable;

    protected $casts = ['is_published' => 'boolean'];
    protected $fillable = ['name', 'description', 'price',];
    protected $with = ['gallery'];
    protected $appends = ['url'];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function locations_available()
    {
        return $this->morphMany(Location::class, 'locatable');
    }

    public function gallery()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function price()
    {
        return "<span>&#8358; </span>" . number_format($this->price, 2);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function shares()
    {
        return $this->morphMany(Share::class, 'shareable');
    }

    public function shouldBeSearchable()
    {
        return $this->is_published === true;
    }

    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
    }

    public function sellable()
    {
        return $this->morphOne(Sellable::class, 'item');
    }
}
