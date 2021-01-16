<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Support\Str;

class DirectConversation extends Model
{
    use HasFactory, QueryCacheable;

    protected $fillable = [
        //
    ];
    protected $appends = [
        'pair',
        'pair_ids'
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

    public function getPairIdsAttribute()
    {
        return [$this->initiator_id, $this->joined_id];
    }

    public function getUnreadFor($profile)
    {
        return $this->messages->filter(function ($message) use ($profile) {
            return $message->sender_id !== $profile->id && (!$message->seenBy->contains($profile));
        })->count();
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($d_conv) {
            $d_conv->secret_key = (string) Str::uuid();
        });
    }

    public function joined()
    {
        return $this->belongsTo(Profile::class, 'joined_id');
    }
}
