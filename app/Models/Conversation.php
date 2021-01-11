<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Conversation extends Model
{
    use HasFactory, QueryCacheable;

    protected $casts = [
        'members' => 'collection'
    ];

    protected $fillable = [
        "type",
        "members"
    ];
    protected $appends = [
        'pair'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function isGroup()
    {
        return $this->type === "group_conversation";
    }

    public function getPair($profileId)
    {
        if ($this->isDirect()) {
            return Profile::firstWhere('id', $this->members->diff([$profileId])->first());
        }
        return "group conversation";
    }

    public function isDirect()
    {
        return $this->type === "direct_conversation";
    }

    public function creator()
    {
        if ($this->isGroup()) {
            return $this->belongsTo(Profile::class, 'creator_id');
        }
        return "direct conversation";
    }
}
