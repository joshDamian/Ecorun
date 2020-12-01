<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Business;
use Livewire\Component;

class ManageBusinessProfile extends Component
{
    public Business $business;

    public function render()
    {
        return view('livewire.connect.profile.manage-business-profile');
    }
}
