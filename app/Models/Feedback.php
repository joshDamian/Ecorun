<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'title',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function feedbackable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->morphMany('App\Models\Feedback', 'feedbackable');
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
}
