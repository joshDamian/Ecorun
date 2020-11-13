<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    protected $with = [
        'followers'
    ];

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function profileable()
    {
        return $this->morphTo();
    }
}
