<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;
    protected $with = [
        'businesses',
        //'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function revoke()
    {
        $this->businesses()->revoke();

        $this->delete();
    }
}
