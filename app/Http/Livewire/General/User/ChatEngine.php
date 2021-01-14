<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatEngine extends Component
{
    public $activeProfile;

    public function mount()
    {
        $this->activeProfile = $this->profiles->current_profile;
    }

    public function getProfilesProperty()
    {
        return Auth::user()->associated_profiles;
    }

    public function switchProfile($profile)
    {
        $this->activeProfile = $this->profiles->all->firstWhere('id', $profile);
        $this->emit('switchedChatProfile', $this->activeProfile);
    }

    public function render()
    {
        return view('livewire.general.user.chat-engine', [
            'profiles' => $this->profiles->all
        ]);
    }
}
