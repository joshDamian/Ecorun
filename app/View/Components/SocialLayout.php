<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class SocialLayout extends Component
{
    public User $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Auth::check()) {
            $this->user = Auth::user()->loadMissing('profile');
        }
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.social');
    }
}
