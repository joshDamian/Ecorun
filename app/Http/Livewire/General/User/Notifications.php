<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;

class Notifications extends Component
{
    public Collection $profiles;
    public Profile $activeProfile;
    public bool $display = false;
    protected $listeners = [
        'showNotifications',
        'hideNotifications',
        'toggleNotifications',
        'newNotification' => '$refresh',
        'markAsRead',
        'deletedStuff' => '$refresh'
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
        $this->profiles = $allProfiles->loadMissing('notifications')->sortBy('id');
        $this->switchProfile($user->currentProfile->id);
        return;
    }

    public function markAsRead(DatabaseNotification $notification, $redirect)
    {
        $notification->markAsRead();
        $this->redirect($redirect);
    }

    public function switchProfile($profile):void
    {
        $this->activeProfile = $this->profiles->find($profile);
        return;
    }

    public function render()
    {
        return view('livewire.general.user.notifications');
    }
}
