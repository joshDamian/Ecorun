<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'title'
    ];
    protected $primaryKey = "title";
    public $incrementing = false;
    protected $with = [
        'products'
    ];
    public function sub_categories()
    {
        return $this->hasMany(Category::class, 'parent_title');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
