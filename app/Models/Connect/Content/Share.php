<?php

namespace App\Models\Connect\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use App\Models\Connect\Profile\Profile;
use App\Models\Build\Sellable\Product\Product;
use App\Models\Build\Sellable\Sellable;

class Share extends Model
{
    use HasFactory, QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function isPost()
    {
        return $this->shareable_type === Post::class;
    }

    public function isSellable()
    {
        return $this->shareable_type === Sellable::class;
    }

    public function isProduct()
    {
        return $this->shareable_type === Product::class;
    }

    public function shareable()
    {
        return $this->morphTo();
    }
}
