<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class NavContent extends Component
{
    public $name;
    public $email;
    public $profileImage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Auth::user()) {
            $this->name = ucwords(Auth::user()->name);
            $this->email = Auth::user()->email;
            $this->profileImage = Auth::user()->profile_photo_url;
        } else {
            $this->name = 'Guest';
            $this->email = '';
            $this->profileImage = '';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.nav-content');
    }
}
