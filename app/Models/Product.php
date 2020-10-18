<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;
    use SoftDeletes;
    protected $with = [
        'attributes'
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

    /* public function toSearchableArray()
    {
        $array = [
            'name' => $this->name,

        ];

        return $array;
    }*/

    use HasFactory;

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function displayImage()
    {
        return $this->gallery->first()->image_url;
    }

    public function price()
    {
        return "<span>&#8358; </span>" . number_format($this->price, 2);
    }
}
