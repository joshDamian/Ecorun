<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;
    protected $with = [
        'enterprises',
        //'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enterprises()
    {
        return $this->hasMany(Enterprise::class);
    }

    public function revoke()
    {
        $this->enterprises()->revoke();

        $this->delete();
    }
}
