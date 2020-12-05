<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Profile;
use Livewire\Component;

class EditProfile extends Component
{
    public Profile $profile;
    protected $rules = [
        'profile.description' => ['required', 'min:20']
    ];

    public function update()
    {
        $this->validate();
        $this->profile->save();
        $this->emitSelf('saved');
    }

    public function render()
    {
        return view('livewire.connect.profile.edit-profile');
    }
}
