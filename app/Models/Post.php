<?php

namespace App\Models;

use App\Events\PostCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Post extends Model
{
    use HasFactory, QueryCacheable;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];

    protected $fillable = [
        'content',
        'visibility'
    ];
    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;

    public function comments()
    {
        return $this->morphMany('App\Models\Feedback', 'feedbackable');
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    public function getContentAttribute($value)
    {
        $sanitized = htmlentities($value);
        return str_replace("\n", "<br>", $sanitized);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function trash(): bool
    {
        Storage::disk('public')->delete($this->gallery->pluck('image_url')->toArray());
        $this->comments()->delete();
        $this->likes()->delete();
        $this->gallery()->delete();
        $this->delete();
        return true;
    }
}
