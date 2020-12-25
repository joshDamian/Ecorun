<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class BusinessLayout extends Component
{
    public $user;
    public $currentProfile;
    public $associatedProfiles;
    public $personalProfile;
    public $currentProfileIsBiz;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Auth::check()) {
            $this->user = Auth::user()->load('profile');
            $this->currentProfile = $this->user->currentProfile->load('profileable');
            $this->personalProfile = $this->user->profile;
            $this->associatedProfiles = $this->user->associatedProfiles();
            $this->currentProfileIsBiz = $this->currentProfile->isBusiness();
        }
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.business');
    }
}
