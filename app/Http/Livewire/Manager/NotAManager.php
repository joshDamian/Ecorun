<?php

namespace App\Http\Livewire\Manager;

use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotAManager extends Component
{
    public function activateManager()
    {
        $manager = new Manager();
        Auth::user()->isManager()->save($manager);
        $this->emit('newManager');
    }

    public function render()
    {
        return view('livewire.manager.not-a-manager');
    }
}
