<?php

namespace App\Http\Livewire\BuildAndManage\Manager;

use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BecomeAManager extends Component
{
    public function activate()
    {
        Auth::user()->isManager()->save(new Manager());
        return $this->emit('newManager');
    }

    public function render()
    {
        return view('livewire.build-and-manage.manager.become-a-manager');
    }
}
