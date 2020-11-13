<?php

namespace App\Http\Livewire\Enterprise;

use App\Models\Service;
use App\Models\Store;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Enterprise;

class CreateNewEnterprise extends Component
{
    public $name;
    public $type;

    protected $rules = [
        'name' => ['required', 'unique:enterprises', 'min:4', 'max:255'],
        'type' => 'required'
    ];

    public function create()
    {
        $this->name = trim($this->name);
        $this->validate();

        $this->name = ucwords($this->name);

        $enterprise = Auth::user()->isManager
            ->enterprises()->create([
                'name' => $this->name
            ]);

        if ($enterprise) {
            $this->assignType($enterprise);
            $team = $this->createTeam();

            if ($enterprise->enterpriseable) {
                $this->create_profile($enterprise);
            }
        }

        $this->emitSelf('created');
        $this->emit('newEnterprise');
        return $enterprise->team()->save($team);
    }

    protected function create_profile(Enterprise $enterprise)
    {
        if ($enterprise->isStore()) {
            $enterprise->profile()->create([
                'description' => "{$enterprise->name} sells quality products, we look forward to satisfying your purchase needs."
            ]);
        } elseif ($enterprise->isService()) {
            $enterprise->profile()->create([
                'description' => "{$enterprise->name} offers quality services, we look forward to making you happy."
            ]);
        }
    }


    protected function createTeam()
    {
        $user = Auth::user();
        return $user->ownedTeams()->create([
            'name' => $this->name . "'s Team",
        ]);
    }

    protected function assignType(Enterprise $enterprise)
    {
        switch ($this->type) {
            case 'service':
                $service = Service::create([]);
                $service->enterprise()->save($enterprise);
                break;
            case 'store':
                $store = Store::create([]);
                $store->enterprise()->save($enterprise);
                break;
            default:
                break;
        }
    }

    public function updated($propertyName)
    {
        //$this->name = trim($this->name);
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.enterprise.create-new-enterprise');
    }
}
