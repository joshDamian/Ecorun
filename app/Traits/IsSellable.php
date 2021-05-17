<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Models\Build\Sellable\Sellable;
use App\Models\Connect\ContentFeedback\Like;
use App\Models\Connect\Content\Share;

trait IsSellable
{
    public function getSellableNameAttribute()
    {
        return Str::of(class_basename($this));
    }

    public function price($quantity = null)
    {
        return "<span>&#8358; </span>" . number_format(($quantity) ? $this->price * $quantity : $this->price, 2);
    }

    public function sellable_item()
    {
        return $this->morphOne(Sellable::class, 'sellable');
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\Core\Media\Image', 'imageable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function shares()
    {
        return $this->morphMany(Share::class, 'shareable');
    }

    public function getVendorAttribute()
    {
        return $this->sellable_item->vendor;
    }
}
