<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'day', 'kickoff', 'close'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
