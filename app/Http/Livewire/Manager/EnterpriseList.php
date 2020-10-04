<?php

namespace App\Http\Livewire\Manager;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EnterpriseList extends Component
{
    public function displayDashboard($enterprise)
    {
        $this->emit('displayEnterpriseDashboard', $enterprise);
    }
    public function render()
    {
        return view('livewire.manager.enterprise-list', [
            'enterprises' => Auth::user()->isManager->enterprises()->latest()->get()
        ]);
    }
}
