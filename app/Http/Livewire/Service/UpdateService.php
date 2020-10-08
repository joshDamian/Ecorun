<?php

namespace App\Http\Livewire\Service;

use App\Models\Service;
use Livewire\Component;

class UpdateService extends Component
{
    public Service $service;

    public function render()
    {
        return view('livewire.service.update-service');
    }
}
