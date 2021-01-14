<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use App\Models\Profile;

class Notifications extends Component
{
    public $user;
    public $activeProfile;
    public bool $display = false;
    protected $listeners = [
        'showNotifications', 'hideNotifications',
        'toggleNotifications', 'modifiedNotifs' => '$refresh',
        'newNotification',
    ];

    public function toggleNotifications(): void
    {
        $this->display = !$this->display;
        return;
    }

    public function showNotifications(): bool
    {
        return $this->display = true;
    }

    public function hideNotifications(): bool
    {
        return $this->display = false;
    }

    public function newNotification($notification)
    {
        return $this->render();
    }

    public function mount()
    {
        $this->activeProfile = $this->profiles->current_profile;
    }

    public function switchProfile($profile): void
    {
        $this->activeProfile = $this->profiles->all->firstWhere('id', $profile);
        $this->emit('switchedProfile', $this->activeProfile)->to('general.user.notification-sorter');
        return;
    }

    public function getNotificationsProperty()
    {
        return $this->user->custom_notifications;
    }

    public function getProfilesProperty()
    {
        return $this->user->associated_profiles;
    }

    public function unreadCount(Profile $profile)
    {
        return $this->notifsForProfile($profile)->filter(function ($notif) {
            return $notif->read_at === null;
        })->count();
    }

    public function notifsForProfile(Profile $profile)
    {
        return $this->notifications->grouped_by_notifiable[$profile->id] ?? collect([]);
    }

    public function render()
    {
        return view('livewire.general.user.notifications', ['profiles' => $this->profiles->all]);
    }
}
