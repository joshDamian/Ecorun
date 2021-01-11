<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class GroupConversation extends Model
{
    use HasFactory, QueryCacheable;

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function members()
    {
        return $this->belongsToMany(Profile::class, 'group_conversation_member', 'group_id', 'member_id')->withTimestamps();
    }

    public function getUnreadFor($profile)
    {
        return $this->messages->filter(function ($message) use ($profile) {
            return  $message->sender_id !== $profile->id && $message->seenBy->contains($profile);
        })->count();
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    public function creator()
    {
        return $this->belongsTo(Profile::class, 'creator_id');
    }
}
