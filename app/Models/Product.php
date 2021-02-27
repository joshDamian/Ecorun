<?php

namespace App\Models;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;
use App\Events\ProductCreated;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Presenters\Product\UrlPresenter;
use App\Scopes\ProductAccessibleScope;
use App\Scopes\ProductViewableScope;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Tags\HasTags;

class Product extends Model
{
    use Searchable,
        SoftDeletes,
        StringManipulations,
        QueryCacheable,
        HasFactory,
        HasTags;

    protected $casts = [
        'is_published' => 'boolean'
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
        'available_stock'
    ];

    protected $with = [
        'gallery'
    ];

    /**
     * The accessors to ap   use HasFactory;pend to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'url'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            try {
                broadcast(new ProductCreated($model))->toOthers();
            } catch (\Throwable $th) {
                report($th);
            }
        });
    }
    public function shouldBeSearchable()
    {
        return $this->is_published === true;
    }

    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function shares()
    {
        return $this->morphMany(Share::class, 'shareable');
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('name', 'ASC');
    }

    public function order_instances()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')->using(OrderProduct::class)->withPivot(['specifications', 'price', 'quantity'])->withTimestamps();
    }

    public function cart_instances()
    {
        return $this->hasMany(Cart::class);
    }

    public function view_history()
    {
        return $this->hasMany(RecentlyViewed::class);
    }

    public function displayImage()
    {
        return $this->gallery()->first()->image_url;
    }

    public function price($quantity = null)
    {
        return "<span>&#8358; </span>" . number_format(($quantity) ? $this->price * $quantity : $this->price, 2);
    }

    public function slugData()
    {
        return [
            'name' => $this->name,
        ];
    }

    public function bootstrap()
    {
        if (Auth::user()) {
            $existing = Auth::user()->view_history()->where('product_id', $this->id)->get()->first();
            if ($existing) {
                $existing->updated_at = now();
                $existing->save();
            } else {
                $this->view_history()->save(
                    Auth::user()->view_history()->save(
                        new RecentlyViewed()
                    )
                );
            }
        } else {
            session()->put("user_product_view_history.{$this->id}", (new RecentlyViewed())->forceFill([
                'product_id' => $this->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'category_title' => $this->category_title,
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ProductAccessibleScope);
        static::addGlobalScope(new ProductViewableScope);
    }

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
    }
}
