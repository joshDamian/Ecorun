<?php

namespace App\Http\Livewire\Store;

use App\Models\Enterprise;
use App\Models\Store;
use Livewire\Component;

class CreateNewStore extends Component
{
    public Enterprise $enterprise;

    public $description;

    protected $rules = [
        'description' => ['required', 'min:20']
    ];

    public function create()
    {
        $this->validate();

        $store = Store::create([
            'description' => $this->description
        ]);

        $store->enterprise()->save($this->enterprise);

        $this->emit('setupDone');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.store.create-new-store');
    }
}
