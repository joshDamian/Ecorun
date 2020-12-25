<?php

namespace App\View\Components;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class NavContent extends Component
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
    public function __construct(User $user, Profile $personalProfile, Collection $associatedProfiles, Profile $currentProfile, bool $currentProfileIsBiz)
    {
        $this->user = $user;
        $this->personalProfile = $personalProfile;
        $this->associatedProfiles = $associatedProfiles;
        $this->currentProfile = $currentProfile;
        $this->currentProfileIsBiz = $currentProfileIsBiz;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('components.nav-content');
    }
}
