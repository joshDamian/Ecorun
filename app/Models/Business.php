<?php

namespace App\Models;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Jetstream\HasProfilePhoto;

class Business extends Model
{
    use HasProfilePhoto;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];
    protected $with = [
        'products',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    use StringManipulations;

    use HasFactory;

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function businessable()
    {
        return $this->morphTo();
    }

    public function profile()
    {
        return $this->morphOne('App\Models\Profile', 'profileable');
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

    public function slugData()
    {
        return [
            'name' => $this->name,
        ];
    }
}
