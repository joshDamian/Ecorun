<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class DirectConversation extends Model
{
    use HasFactory, QueryCacheable;

    protected $fillable = [
        //
    ];
    protected $appends = [
        'pair'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    public function initiator()
    {
        return $this->belongsTo(Profile::class, 'initiator_id');
    }

    public function getPairAttribute()
    {
        return collect([$this->initiator, $this->joined]);
    }

    public function getUnreadFor($profile)
    {
        return $this->messages->filter(function ($message) use ($profile) {
            return  $message->sender_id !== $profile->id && $message->seenBy->contains($profile);
        })->count();
    }

    public function joined()
    {
        return $this->belongsTo(Profile::class, 'joined_id');
    }
}
