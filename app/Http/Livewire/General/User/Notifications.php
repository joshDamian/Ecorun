<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Collection as SupportCollection;

class Notifications extends Component
{
    public Collection $profiles;
    public Profile $activeProfile;
    public bool $display = false;
    public User $user;
    protected $listeners = [
        'showNotifications',
        'hideNotifications',
        'toggleNotifications',
        'modifiedNotifs' => '$refresh',
        'switchedActiveProfile' => '$refresh'
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

    public function mount(array $profileIds, User $user): void
    {
        $this->user = $user;
        $this->profiles = Profile::cacheFor(3600)->with(['notifications'])->whereIn('id', $profileIds)->get()->unique();
        $this->switchProfile($this->user->currentProfile->id);
        return;
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
        $this->activeProfile = $this->profiles->find($profile);
        $this->emit('switchedActiveProfile');
        return;
    }

    public function render()
    {
        return view('livewire.general.user.notifications');
    }
}
