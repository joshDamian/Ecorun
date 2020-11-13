<?php

namespace App\Http\Livewire\Profile;

use App\Models\Enterprise;
use Livewire\Component;

class ManageEnterpriseProfile extends Component
{
    public Enterprise $enterprise;
    public function render()
    {
        return view('livewire.profile.manage-enterprise-profile');
    }
}
