<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $fillable = [
        'name',
    ];
    protected $with = [
        'products'
    ];
    use HasFactory;

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function enterpriseable()
    {
        return $this->morphTo();
    }

    public function coverPhoto()
    {
        $cover_photo = $this->gallery()->whereLabel('cover_photo')->first();
        return  ($cover_photo) ? $cover_photo->image_url : null;
    }

    public function isStore()
    {
        return $this->enterpriseable instanceof Store;
    }

    public function isService()
    {
        return $this->enterpriseable instanceof Service;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
}
