<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Conversation extends Model
{
    use HasFactory,
    QueryCacheable;

    protected $casts = [
        'members' => 'collection'
    ];

    protected $fillable = [
        "type",
        "members"
    ];
    protected $appends = [
        'members'
    ];
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function isGroup() {
        return $this->type === "group_conversation";
    }

    public function getPair($profileId) {
        if ($this->isDirect()) {
            return $this->members->except([$profileId])->first();
        }
        return "group conversation";
    }

    public function getMembersAttribute($value) {
        return Profile::whereIn('id', json_decode($value))->get();
    }

    public function isDirect() {
        return $this->type === "direct_conversation";
    }

    public function creator() {
        return $this->belongsTo(Profile::class, 'creator_id')->withDefault();
    }
}