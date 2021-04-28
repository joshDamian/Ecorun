<?php

namespace App\Models\Core\DataSorting;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Category extends Model
{
    use HasFactory, Searchable, StringManipulations, QueryCacheable;

    protected $fillable = [
        'title'
    ];
    protected $primaryKey = "title";
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public $incrementing = false;

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_title');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function isParent()
    {
        return $this->children->count() > 0;
    }

    public function slugData()
    {
        return [
            'title' => $this->title,
        ];
    }
}
