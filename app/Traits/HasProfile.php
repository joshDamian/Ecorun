<?php

namespace App\Traits;

use App\Models\Profile;

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

    public function currentProfile()
    {
        return $this->belongsTo(Profile::class, 'current_profile_id');
    }
}
