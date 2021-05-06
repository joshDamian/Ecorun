<?php

namespace App\Http\Livewire\BuildAndManage\Service;

use App\Models\Buy\Service\Service;
use Livewire\Component;

class ServiceDashboard extends Component
{
    public Service $service;
    public function render()
    {
        return view('livewire.build-and-manage.service.service-dashboard');
    }
}
