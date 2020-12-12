<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $with = [
        'likes',
        'comments',
        'gallery',
        //'profile'
    ];

    protected $fillable = [
        'content',
        'visibility'
    ];

    public function comments() {
        return $this->morphMany('App\Models\Feedback', 'feedbackable')->latest();
    }

    public function gallery() {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function likes() {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    public function profile() {
        return $this->belongsTo(Profile::class);
    }
}