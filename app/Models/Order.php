<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'products'
    ];

    protected $casts = [
        'products' => 'array'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
