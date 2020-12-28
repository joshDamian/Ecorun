<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use App\Models\User;

class UnreadNotifsDisplay extends Component
{
    public User $user;
    protected $listeners = [
        'newNotification' => '$refresh'
    ];

    public function render()
    {
        return view(
            'livewire.general.user.unread-notifs-display',
            [
            'count' => $this->user->associatedProfiles()->concat([$this->user->loadMissing('profile')->profile])->loadCount('unreadNotifications')->map(
                function ($profile):int {
                    return $profile->unread_notifications_count;
                }
            )->sum()
            ]
        );
    }
}
