<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Profile;
use Livewire\Component;

class ProfileNotificationHandler extends Component
{
    public Profile $profile;
    public $count;

    public function mount()
    {
        return $this->counter();
    }

    public function counter()
    {
        return $this->count = $this->profile->unreadNotifications->count();
    }

    public function render()
    {
        return view('livewire.connect.profile.profile-notification-handler');
    }
}
