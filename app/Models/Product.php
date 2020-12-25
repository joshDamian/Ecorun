<?php

namespace App\Models;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;
    use SoftDeletes;
    use StringManipulations;

    protected $with = [
        //'specifications',
        //'gallery',
    ];

    protected $casts = [
        'is_published' => 'boolean'
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
        'available_stock'
    ];

    use HasFactory;

    public function business()
    {
        return $this->belongsTo(Business::class);
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

    public function indicatedSpecs()
    {
        return $this->specifications()->where('is_specific', true)->get();
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
        return $this->gallery->first()->image_url;
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
                $existing->updated_at = time();
                $existing->save();
            } else {
                $this->view_history()->save(
                    Auth::user()->view_history()->save(
                        new RecentlyViewed()
                    )
                );
            }
        } else {
            $product_view_history = session()->get('product_view_history', []);
            (!in_array($this->id, $product_view_history)) ? session()->push("product_view_history", $this->id) : true;
        }
    }
}
