<?php

namespace App\Http\Livewire\Service;

use App\Models\Service;
use Livewire\Component;

class EditService extends Component
{
    public Service $service;

    protected $rules = [
        'service.description' => ['required', 'min:20']
    ];

    public function edit()
    {
        $this->validate();
        $this->service->save();

        $this->emitSelf('saved');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.service.edit-service');
    }
}
