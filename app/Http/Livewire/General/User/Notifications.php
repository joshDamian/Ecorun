<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use App\Models\Profile;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection as SupportCollection;

class Notifications extends Component
{
    public $user;
    public bool $display = false;
    protected $listeners = [
        'showNotifications',
        'hideNotifications',
        'toggleNotifications',
        'modifiedNotifs' => '$refresh',
        'newNotification' => '$refresh',
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

    public function switchProfile($profile): void
    {
        cache()->put($this->user->id . "active_profile_for_notif", $this->profiles->firstWhere("id", $profile));
        $this->emit('switchedProfile', $this->activeProfile)->to('general.user.notification-sorter');
        return;
    }

    public function getNotificationsProperty()
    {
        return $this->user->custom_notifications;
    }

    public function getActiveProfileProperty()
    {
        return cache()->remember($this->user->id . "active_profile_for_notif", now()->addDays(60), function () {
            return $this->user->currentProfile;
        });
    }

    public function getProfilesProperty()
    {
        return $this->user->associated_profiles->all;
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
        return view('livewire.general.user.notifications', ['profiles' => $this->profiles]);
    }
}
