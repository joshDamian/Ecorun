<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'visibility'
    ];

    public function gallery()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
