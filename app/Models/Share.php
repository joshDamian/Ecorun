<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function isPost()
    {
        return $this->shareable_type === Post::class;
    }

    public function isProduct()
    {
        return $this->shareable_type === Product::class;
    }

    public function shareable()
    {
        return $this->morphTo();
    }
}
