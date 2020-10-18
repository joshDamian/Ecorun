<?php

namespace App\Http\Livewire\Manager;

use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BecomeAManager extends Component
{
    public function activate()
    {
        Auth::user()->isManager()->save(new Manager());
        $this->emit('newManager');
        
    }

    public function render()
    {
        return view('livewire.manager.become-a-manager');
    }
}
