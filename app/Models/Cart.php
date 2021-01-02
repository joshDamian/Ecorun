<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Cart extends Model
{
    use HasFactory, QueryCacheable;
    
    protected $with = [
        'product'
    ];
    protected $casts = [
        'specifications' => 'array'
    ];

    protected $fillable = [
        'quantity',
        'specifications'
    ];
    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
