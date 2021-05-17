<?php

namespace App\Http\Livewire\BuildAndManage\Service;

use Livewire\Component;

class ServiceDashboard extends Component
{
    public $item;
    public function render()
    {
        return view('livewire.build-and-manage.service.service-dashboard', [
            'service' => $this->item->sellable
        ]);
    }
}
