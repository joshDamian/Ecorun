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

    public function shareable()
    {
        return $this->morphTo();
    }
}
