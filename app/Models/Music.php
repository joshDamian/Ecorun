<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $casts = [
        'associated_acts' => 'collection'
    ];
    protected $attributes = [
        'associated_acts' => "[]"
    ];

    public function audio() {
        return $this->morphOne(Audio::class, 'attachable');
    }

    public function video() {
        return $this->morphOne(Video::class, 'attachable');
    }

    public function attachable() {
        return $this->morphTo();
    }
}