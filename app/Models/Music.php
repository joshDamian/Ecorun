<?php

namespace App\Models;

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
    protected $appends = [
        'cover_art_url'
    ];

    public function audio() {
        return $this->morphOne(Audio::class, 'attachable');
    }

    public function video() {
        return $this->morphOne(Video::class, 'attachable');
    }

    public function attachable() {
        return $this->morphTo();
    }

    public function getCoverArtUrlAttribute() {
        return ($this->cover_art) ? '/storage/' . $this->cover_art : '/app-images/music_player.jpg';
    }
}