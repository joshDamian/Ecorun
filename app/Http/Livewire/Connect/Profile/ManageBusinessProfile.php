<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Connect\Profile\Profile;
use Livewire\Component;

class ManageBusinessProfile extends Component
{
    public Profile $profile;

    public function render()
    {
        return view('livewire.connect.profile.manage-business-profile');
    }
}
