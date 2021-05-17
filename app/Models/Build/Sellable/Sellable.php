<?php

namespace App\Models\Build\Sellable;

use App\Scopes\SellableAccessibleScope;
use App\Scopes\SellableViewableScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sellable extends Model
{
    use HasFactory;

    protected $casts = ['is_published' => 'boolean'];

    public function sellable()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
        self::deleted(function ($model) {
            $model->sellable()->delete();
        });
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new SellableAccessibleScope);
        static::addGlobalScope(new SellableViewableScope);
    }

    public function vendor()
    {
        return $this->morphTo();
    }
}
