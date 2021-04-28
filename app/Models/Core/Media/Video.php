<?php

namespace App\Models\Core\Media;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    public function attachable()
    {
        return $this->morphTo();
    }
}
