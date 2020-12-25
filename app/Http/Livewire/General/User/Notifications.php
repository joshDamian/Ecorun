<?php

namespace App\Http\Livewire\General\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Profile;

class Notifications extends Component
{
    public $associatedProfiles;
    public $personal_profile;
    public $currentProfile;
    public $activeProfile;
    public $display = false;
    protected $listeners = [
        'showNotifications',
        'hideNotifications',
        'toggleNotifications'
    ];

    public function toggleNotifications()
    {
        $this->display = !$this->display;
    }

    public function showNotifications()
    {
        return $this->display = true;
    }

    public function hideNotifications()
    {
        return $this->display = false;
    }

    public function mount():void
    {
        $user = Auth::user()->loadMissing('profile.unreadNotifications', 'currentProfile.unreadNotifications');
        $this->personal_profile = $user->profile;
        $this->activeProfile = $this->currentProfile = $user->currentProfile;
        $this->associatedProfiles = $user->associatedProfiles();
        return;
    }

    public function switchProfile(Profile $profile)
    {
        $this->activeProfile = $profile->loadMissing('notifications');
        return;
    }

    public function render()
    {
        return view('livewire.general.user.notifications');
    }
}
