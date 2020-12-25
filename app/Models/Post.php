<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $with = [
        'likes',
        'comments',
        'gallery',
    ];

    protected $fillable = [
        'content',
        'visibility'
    ];

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
