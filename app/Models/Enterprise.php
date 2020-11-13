<?php

namespace App\Models;

use App\Traits\StringManipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\HasProfilePhoto;

class Enterprise extends Model
{
    use HasProfilePhoto;

    protected $fillable = [
        'name',
    ];
    protected $with = [
        'products',
        //'enterpriseable',
        //'profile'
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

    public function enterpriseable()
    {
        return $this->morphTo();
    }

    public function profile()
    {
        return $this->morphOne('App\Models\Profile', 'profileable');
    }

    /* public function coverPhoto()
    {
        $cover_photo = $this->gallery()->whereLabel('cover_photo')->first();
        return ($cover_photo) ? $cover_photo->image_url : null;
    } */

    public function isStore()
    {
        return $this->enterpriseable instanceof Store;
    }

    public function isService()
    {
        return $this->enterpriseable instanceof Service;
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

    public function offline_locations()
    {
        return $this->hasMany(EnterpriseOfflineLocation::class);
    }

    public function slugData()
    {
        return [
            'name' => $this->name,
        ];
    }
}
