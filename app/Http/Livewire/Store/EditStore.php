<?php

namespace App\Http\Livewire\Store;

use App\Models\Store;
use Livewire\Component;

class EditStore extends Component
{
    public Store $store;

    protected $rules = [
        "store.description" => ['required', 'min:20']
    ];

    public function edit()
    {
        $this->validate();
        $this->store->save();

        $this->emitSelf('saved');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.store.edit-store');
    }
}
