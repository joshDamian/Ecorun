<?php

namespace App\Http\Livewire\Manager;

use Livewire\Component;

class Dashboard extends Component
{
    protected $listeners = [
        'newManager' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.manager.dashboard');
    }
}
