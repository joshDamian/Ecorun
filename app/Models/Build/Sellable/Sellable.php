<?php

namespace App\Models\Build\Sellable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sellable extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
        self::deleted(function ($model) {
            $model->item()->delete();
        });
    }

    public function vendor()
    {
        return $this->morphTo();
    }
}
