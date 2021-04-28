<?php

namespace App\Models\Core\Media;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Image extends Model
{
    use QueryCacheable, HasFactory;

    protected $fillable = [
        'image_url',
        'label'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function imageable()
    {
        return $this->morphTo();
    }
}
