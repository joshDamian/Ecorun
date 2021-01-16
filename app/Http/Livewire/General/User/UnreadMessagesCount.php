<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;
use App\Models\User;

class UnreadMessagesCount extends Component
{
    public User $user;
    protected $listeners = [
        'newMessage' => '$refresh',
        'readMessages' => '$refresh'
    ];
    public function render() {
        return view('livewire.general.user.unread-messages-count', [
            'count' => $this->user->unread_messages_count
        ]);
    }
}