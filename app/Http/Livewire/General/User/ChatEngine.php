<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ChatEngine extends Component
{
    public function getProfilesProperty()
    {
        return Auth::user()->associated_profiles;
    }

    public function getActiveProfileProperty()
    {
        return Cache::rememberForever('activeProfileForChat' . Auth::user()->id, function () {
            return $this->profiles->current_profile;
        });
    }

    public function switchProfile($profile)
    {
        Cache::put('activeProfileForChat' . Auth::user()->id, $this->profiles->all->firstWhere('id', $profile));
        $this->emit('switchedChatProfile', $this->activeProfile);
    }

    public function render()
    {
        return view('livewire.general.user.chat-engine', [
            'profiles' => $this->profiles->all
        ]);
    }
}
