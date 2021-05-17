<?php

namespace App\Models\Core\Media;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    public static function boot()
    {
        parent::boot();
        self::deleted(function ($model) {
            Storage::disk('public')->delete($model->image_url);
        });
    }
}
