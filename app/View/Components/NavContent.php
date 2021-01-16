<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavContent extends Component
{
    public $currentProfile;
    public $hasMultipleProfiles;
    public $other_profiles;
    public $associatedProfiles;
    public $personalProfile;
    public $currentProfileIsBiz;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($associatedProfiles)
    {
        $this->associatedProfiles = $associatedProfiles;
        $this->personalProfile = $this->associatedProfiles->personal_profile;
        $this->other_profiles = $this->associatedProfiles->all->filter(function ($profile) {
            return $profile !== $this->personalProfile;
        });
        $this->hasMultipleProfiles = $this->other_profiles->count() > 0;
        $this->currentProfile = $this->associatedProfiles->current_profile;
        $this->currentProfileIsBiz = $this->currentProfile->isBusiness();
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
