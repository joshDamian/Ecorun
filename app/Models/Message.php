<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Message extends Model
{
    use HasFactory, QueryCacheable;

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['conversation'];
    protected $fillable = [
        'content',
        'privacy_level',
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belondsTo(Profile::class, 'sender_id')->withDefault();
    }
}
