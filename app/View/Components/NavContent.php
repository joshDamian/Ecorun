<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class NavContent extends Component
{
    public $user;
    public $currentProfile;
    public $associatedProfiles;
    public $personal_profile;
    public $currentProfile_is_biz;

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
            $this->personal_profile = $this->user->profile;
            $this->associatedProfiles = $this->user->associatedProfiles();
            $this->currentProfile_is_biz = $this->currentProfile->isBusiness();
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
