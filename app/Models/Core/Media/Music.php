<?php

namespace App\Models\Core\Media;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Music extends Model
{
    use HasFactory,
        QueryCacheable;

    protected $casts = [
        'associated_acts' => 'collection'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
    protected $attributes = [
        'associated_acts' => "[]"
    ];
    protected $with = [
        'audio'
    ];

    public function audio()
    {
        return $this->morphOne(Audio::class, 'attachable');
    }

    public function video()
    {
        return $this->morphOne(Video::class, 'attachable');
    }

    public function attachable()
    {
        return $this->morphTo();
    }
}
