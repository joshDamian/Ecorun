<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class Notifications extends Component
{
    public Collection $profiles;
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

    public function mount(Collection $allProfiles, User $user):void
    {
        $this->profiles = $allProfiles->loadMissing('unreadNotifications')->sortBy('id');
        $this->activeProfile = $this->profiles->find($user->currentProfile->id);
        return;
    }

    public function switchProfile(Profile $profile):void
    {
        $this->activeProfile = $profile->loadMissing('notifications', 'unreadNotifications');
        return;
    }

    public function render()
    {
        return view('livewire.general.user.notifications');
    }
}
