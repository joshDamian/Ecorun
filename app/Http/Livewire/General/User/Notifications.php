<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class Notifications extends Component
{
    public Collection $profiles;
    public Profile $activeProfile;
    public bool $display = false;
    protected $listeners = [
        'showNotifications',
        'hideNotifications',
        'toggleNotifications',
        'newNotification' => '$refresh'
    ];

    public function toggleNotifications():void
    {
        $this->display = !$this->display;
        return;
    }

    public function showNotifications():bool
    {
        return $this->display = true;
    }

    public function hideNotifications():bool
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
