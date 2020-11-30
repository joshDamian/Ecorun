<?php

namespace App\Http\Livewire\BuildAndManage\Manager;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManagerBusinessList extends Component
{
    protected $listeners = [
        'newEnterprise' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.build-and-manage.manager.manager-business-list', [
            'enterprises' => Auth::user()->isManager->enterprises
        ]);
    }
}
