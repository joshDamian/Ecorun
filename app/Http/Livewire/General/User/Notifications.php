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
    public Profile $activeProfile;
    public bool $display = false;
    protected $listeners = [
        'showNotifications',
        'hideNotifications',
        'toggleNotifications',
        'modifiedNotifs' => '$refresh',
        //'switchedActiveProfile' => '$refresh'
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

    public function handle(DatabaseNotification $notification, $redirect)
    {
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }
        $this->user->switchProfile($notification->loadMissing('notifiable')->notifiable);
        $this->redirect($redirect);
    }

    public function switchProfile($profile): void
    {
        $this->activeProfile = $this->profiles->firstWhere("id", $profile);
        $this->emitUp('switchedActiveProfile' . $this->activeProfile, $this->notifications->grouped_by_notifiable[$this->activeProfile->id] ?? collect([]));
        return;
    }

    public function getNotificationsProperty()
    {
        return $this->user->custom_notifications;
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
