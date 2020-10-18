<?php

namespace App\Http\Livewire\Service;

use App\Models\Enterprise;
use App\Models\Service;
use Livewire\Component;

class CreateNewService extends Component
{
    public Enterprise $enterprise;

    public $description;

    protected $rules = [
        'description' => ['required', 'min:20']
    ];

    public function create()
    {
        $this->validate();

        $service = Service::create([
            'description' => $this->description
        ]);

        $service->enterprise()->save($this->enterprise);

        $this->emit('setupDone');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.service.create-new-service');
    }
}
