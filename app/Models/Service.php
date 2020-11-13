<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $with = [
        'working_days'
    ];

    public function enterprise()
    {
        return $this->morphOne('App\Models\Enterprise', 'enterpriseable');
    }

    public function working_days()
    {
        return $this->hasMany(ServiceWorkingDay::class);
    }
}
