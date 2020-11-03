<?php

namespace App\Models;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    use StringManipulations;

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

    public function canBeSingular() {
        return [
            'name' => $this->name
        ];
    }
}
