<?php

namespace App\Models\Information\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'city', 'state', 'address_line',
    ];

    public function locateable()
    {
        return $this->morphTo();
    }
}
