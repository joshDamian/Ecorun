<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $casts = [
        'attributes' => 'array'
    ];
    protected $fillable = [
        'name',
        'description',
        'attributes',
        'price'
    ];
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
}
