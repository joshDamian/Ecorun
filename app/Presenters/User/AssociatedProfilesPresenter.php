<?php

namespace App\Presenters\User;

use App\DataBanks\User\AssociatedProfilesDataBank;
use App\Models\User;
use App\Presenters\Presenter;

class AssociatedProfilesPresenter
{
    use Presenter;

    protected User $user;
    protected $associatedProfiles;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->associatedProfiles =  (new AssociatedProfilesDataBank($this->user))->fetch();
    }

    public function owned_business_profiles()
    {
        return $this->associatedProfiles["owned_business_profiles"];
    }

    public function team_business_profiles()
    {
        return $this->associatedProfiles["team_business_profiles"];
    }

    public function personal_profile()
    {
        return $this->associatedProfiles['personal_profile'];
    }

    public function current_profile()
    {
        return $this->all->firstWhere('id', $this->associatedProfiles['current_profile_id']);
    }

    public function all()
    {
        return $this->associatedProfiles->except(['current_profile_id'])->flatten();
    }
}
