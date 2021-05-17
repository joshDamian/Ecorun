<?php

namespace App\Models\Buy\Service;

use App\Models\Information\Basic\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Presenters\Service\UrlPresenter;
use App\Traits\IsSellable;
use App\Models\Core\DataSorting\Tag;
use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Tags\HasTags;


class Service extends Model
{
    use HasFactory, SoftDeletes, QueryCacheable, HasTags, Searchable, IsSellable, StringManipulations;

    protected $casts = ['is_published' => 'boolean'];
    protected $fillable = ['name', 'description', 'price', 'pricing'];
    protected $with = ['gallery'];
    protected $appends = ['url'];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function locations_available()
    {
        return $this->morphMany(Location::class, 'locatable');
    }

    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }

    public function shouldBeSearchable()
    {
        return $this->is_published === true;
    }

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
    }
}
