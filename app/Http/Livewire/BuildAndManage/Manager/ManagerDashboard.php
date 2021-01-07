<?php

namespace App\Http\Livewire\BuildAndManage\Manager;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ManagerDashboard extends Component
{
    protected $listeners = [
        'newManager' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.build-and-manage.manager.manager-dashboard')->layout('layouts.business', ['user' => Auth::user()]);
    }
}
