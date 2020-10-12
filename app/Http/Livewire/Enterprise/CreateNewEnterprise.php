<?php

namespace App\Http\Livewire\Enterprise;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateNewEnterprise extends Component
{
    public $name;

    protected $rules = [
        'name' => ['required', 'unique:enterprises', 'min:4', 'max:255']
    ];

    public function create()
    {
        $this->validate();

        $this->name = ucwords($this->name);

        $enterprise = Auth::user()->isManager
            ->enterprises()->create([
                'name' => $this->name
            ]);

        $team = $this->createTeam();

        $this->emitSelf('created');
        $this->emit('newEnterprise');
        return $enterprise->team()->save($team);
    }

    protected function createTeam()
    {
        $user = Auth::user();
        return $user->ownedTeams()->create([
            'name' => $this->name . "'s Team",
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.enterprise.create-new-enterprise');
    }
}
