<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UnreadNotifsDisplay extends Component
{
    public User $user;
    protected $listeners = [
        'newNotification' => '$refresh',
        'deletedFromNotifications' => '$refresh'
    ];

    public function render()
    {
        return view(
            'livewire.general.user.unread-notifs-display',
            [
                'count' => $this->user->custom_notifications->unread_count
            ]
        );
    }
}
