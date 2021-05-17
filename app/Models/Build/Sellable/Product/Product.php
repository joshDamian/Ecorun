<?php

namespace App\Models\Build\Sellable\Product;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use App\Events\ProductEvents\ProductCreated;
use App\Presenters\Product\UrlPresenter;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Traits\IsSellable;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Tags\HasTags;
use App\Models\Core\DataSorting\Tag;

class Product extends Model
{
    use Searchable,
        SoftDeletes,
        StringManipulations,
        QueryCacheable,
        HasFactory,
        IsSellable,
        HasTags;

    protected $casts = ['is_published' => 'boolean'];
    protected $fillable = [
        'name', 'description', 'price', 'available_stock'
    ];
    protected $with = ['gallery'];
    /**
     * The accessors to ap   use HasFactory;pend to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url'];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

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
        self::forceDeleted(function ($model) {
            $model->trash();
        });
    }

    public function trash()
    {
        $this->gallery()->delete();
        $this->likes()->delete();
        $this->shares()->delete();
        $this->specifications()->delete();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('name', 'ASC');
    }

    public function order_instances()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')->using(OrderProduct::class)->withPivot([
            'specifications', 'price', 'quantity', 'id', 'status'
        ])->as('orderRequest')->withTimestamps();
    }

    /* public function cart_instances()
    {
        return $this->hasMany(Cart::class);
    }

    public function view_history()
    {
        return $this->hasMany(RecentlyViewed::class);
    } */

    public function displayImage()
    {
        return $this->gallery()->first()->image_url;
    }

    public function slugData()
    {
        return [
            'name' => $this->name,
        ];
    }

    public function bootstrap()
    {
        /* if (Auth::user()) {
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
        } */
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'category_title' => $this->category_title,
        ];
    }

    public function shouldBeSearchable()
    {
        return $this->is_published === true;
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

    public function getUrlAttribute()
    {
        return (new UrlPresenter($this));
    }
}
