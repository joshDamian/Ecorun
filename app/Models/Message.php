<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Message extends Model
{
    use HasFactory,
    QueryCacheable;

    /**
    * All of the relationships to be touched.
    *
    * @var array
    */
    protected $touches = ['messageable'];
    protected $fillable = [
        'content',
        'privacy_level',
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
    protected $with = [
        'seenBy'
    ];
    protected $appends = [
        'status',
    ];

    public function messageable() {
        return $this->morphTo();
    }

    public function seenBy() {
        return $this->belongsToMany(Profile::class, 'message_reader', 'reader_id', 'message_id')->withTimestamps();
    }

    public function getStatusAttribute() {
        if ($this->messageable_type === GroupConversation::class) {
            return 'sent';
        }
        if ($this->seenBy->count() > 0) {
            return 'seen';
        }
        return 'sent';
    }

    public function sender() {
        return $this->belongsTo(Profile::class, 'sender_id')->withDefault();
    }
}