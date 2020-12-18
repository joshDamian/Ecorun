<?php

namespace App\Http\Livewire\General\User;

use Livewire\Component;

class Notifications extends Component
{
    public $display = false;
    protected $listeners = [
        'showNotifications',
        'hideNotifications',
        'toggleNotifications'
    ];

    public function toggleNotifications()
    {
        $this->display = !$this->display;
    }

    public function showNotifications()
    {
        return $this->display = true;
    }

    public function hideNotifications()
    {
        return $this->display = false;
    }

    public function render()
    {
        return view('livewire.general.user.notifications');
    }
}
