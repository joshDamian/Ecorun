<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $with = [
        'enterprise'
    ];

    protected $fillable = [
        'description'
    ]
    
    public function enterprise()
    {
        return $this->morphOne('App\Models\Enterprise', 'enterpriseable');
    }
}
