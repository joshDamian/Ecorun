<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'working_days',
    ];

    protected $with = [
        'enterprise'
    ];

    protected $casts = [
        'working_days' => 'array'
    ];

    public function enterprise()
    {
        return $this->morphOne('App\Models\Enterprise', 'enterpriseable');
    }
}
