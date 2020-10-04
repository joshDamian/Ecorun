<?php

namespace App\Http\Livewire\Enterprise;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateEnterprise extends Component
{
    public $name;
    protected $rules = [
        'name' => [
            'required',
            'min:4',
            'unique:enterprises'
        ]
    ];

    public function createEnterprise()
    {
        $this->validate();

        Auth::user()->isManager->enterprises()->create([
            'name' => ucwords(strtolower($this->name))
        ]);

        $this->emit('newEnterprise');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.enterprise.create-enterprise');
    }
}
