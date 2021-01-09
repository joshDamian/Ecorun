<?php

namespace App\DataBanks\User;

use App\DataBanks\DataBank;
use App\Models\User;

class AssociatedProfilesDataBank implements DataBank
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function fetch()
    {
        $this->user = $this->user->loadMissing('profile', 'teams.business.profile', 'isManager.businesses.profile', 'currentProfile');
        $business_profiles = $this->user->isManager->businesses->pluck('profile');
        $team_business_profiles = $this->user->teams->pluck('business.profile');
        return collect(['personal_profile' => $this->user->profile, 'owned_business_profiles' => $business_profiles, 'team_business_profiles' => $team_business_profiles, 'current_profile_id' => $this->user->currentProfile->id]);
    }
}
