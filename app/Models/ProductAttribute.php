<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $casts = [
        'value' => 'array'
    ];

    protected $fillable = [
        'name',
        'value'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
