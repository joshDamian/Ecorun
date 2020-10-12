<?php

namespace App\Http\Livewire\Manager;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EnterpriseList extends Component
{
    protected $listeners = [
        'newEnterprise' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.manager.enterprise-list', [
            'enterprises' => Auth::user()->isManager->enterprises
        ]);
    }
}
