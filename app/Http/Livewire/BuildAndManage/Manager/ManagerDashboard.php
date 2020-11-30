<?php

namespace App\Http\Livewire\BuildAndManage\Manager;

use Livewire\Component;

class ManagerDashboard extends Component
{
    protected $listeners = [
        'newManager' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.build-and-manage.manager.manager-dashboard');
    }
}
