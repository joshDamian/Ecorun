<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function vendor()
    {
        return $this->morphTo();
    }

    public function purchaseable()
    {
        return $this->morphTo();
    }

    public function buyer()
    {
        return $this->morphTo();
    }
}
