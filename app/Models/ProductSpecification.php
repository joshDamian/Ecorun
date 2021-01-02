<?php

namespace App\Models;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class ProductSpecification extends Model
{
    use HasFactory, StringManipulations, QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;

    protected $casts = [
        'value' => 'array',
        'is_specific' => 'boolean'
    ];

    protected $fillable = [
        'name',
        'value',
        'is_specific'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function canBeSingular()
    {
        return [
            'name' => $this->name
        ];
    }
}
