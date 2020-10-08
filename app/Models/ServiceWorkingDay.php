<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceWorkingDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'day', 'kickoff', 'close'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
