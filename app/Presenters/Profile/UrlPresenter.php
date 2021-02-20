<?php

namespace App\Presenters\Profile;

use App\Models\Profile;

class UrlPresenter
{
    protected Profile $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return (property_exists($this, $key)) ? $this->$key : null;
    }

    public function following()
    {
        return route('profile.following', $this->profile);
    }

    public function followers()
    {
        return route('profile.followers', $this->profile);
    }

    public function bookmarks()
    {
        return route('bookmark.show', $this->profile);
    }

    public function visit()
    {
        return route('profile.visit', $this->profile);
    }

    public function edit()
    {
        if ($this->profile->isUser()) {
            return route('profile.edit', $this->profile);
        }
        return $this->business_url . '/edit';
    }

    public function business_url()
    {
        if ($this->profile->isUser()) {
            return null;
        }
        return route('business.dashboard', $this->profile);
    }

    public function products()
    {
        $business_url = $this->business_url;
        if ($business_url) {
            return $business_url . '/products';
        }
        return null;
    }

    public function add_product()
    {
        $business_url = $this->business_url;
        if ($business_url) {
            return $business_url . '/add-product';
        }
        return null;
    }

    public function team()
    {
        $business_url = $this->business_url;
        if ($business_url) {
            return $business_url . '/team';
        }
        return null;
    }

    public function orders()
    {
        $business_url = $this->business_url;
        if ($business_url) {
            return $business_url . '/orders';
        }
        return null;
    }
}
