<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;

class CreateNewProfile extends Component
{
    public $description;
    public $profileable;

    protected $rules = [
        'description' => ['required', 'min:20']
    ];

    public function create()
    {
        $this->validate();
        $this->profileable->profile()->create([
            'description' => $this->description
        ]);
        $this->emitSelf('saved');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.profile.create-new-profile');
    }
}
