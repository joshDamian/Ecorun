<?php

namespace App\Traits;

trait HasProfile
{
    public function profile()
    {
        return $this->morphOne('App\Models\Profile', 'profileable');
    }

    public function profile_image()
    {
        return $this->profile->profile_photo_url;
    }

    public function name()
    {
        return $this->profile->name;
    }
}
