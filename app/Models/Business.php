<?php

namespace App\Models;

use App\Traits\HasProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{

    use SoftDeletes;
    use HasProfile;

    protected $with = [
        'products',
    ];

    use HasFactory;

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function businessable()
    {
        return $this->morphTo();
    }

    public function isStore()
    {
        return $this->businessable instanceof Store;
    }

    public function isService()
    {
        return $this->businessable instanceof Service;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function locations()
    {
        return $this->morphMany('App\Models\Location', 'locateable');
    }
}
