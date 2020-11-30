<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Enterprise;
use Livewire\Component;

class ManageBusinessProfile extends Component
{
    public Enterprise $enterprise;
    public function render()
    {
        return view('livewire.connect.profile.manage-business-profile');
    }
}
