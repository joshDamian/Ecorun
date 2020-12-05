<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Service;
use App\Models\Store;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;

class CreateNewBusiness extends Component
{
    public $name;
    public $type;

    protected $rules = [
        'name' => [
            'required',
            'unique:businesses',
            'min:4',
            'max:255'
        ],
        'type' => 'required'
    ];

    public function create() {
        $this->name = trim($this->name);
        $this->validate();

        $this->name = ucwords($this->name);

        $business = Auth::user()->isManager
        ->businesses()->create([
            'name' => $this->name
        ]);

        if ($business) {
            $this->assignType($business);
            $team = $this->createTeam();

            if ($business->businessable) {
                $this->create_profile($business);
            }
        }

        $this->emitSelf('created');
        $this->emit('newBusiness');
        return $business->team()->save($team);
    }

    protected function create_profile(Business $business) {
        if ($business->isStore()) {
            $business->profile()->create([
                'description' => "{$business->name} sells quality products, we look forward to satisfying your purchase needs."
            ]);
        } elseif ($business->isService()) {
            $business->profile()->create([
                'description' => "{$business->name} offers quality services, we look forward to making you happy."
            ]);
        }
    }


    protected function createTeam() {
        $user = Auth::user();
        return $user->ownedTeams()->create([
            'name' => $this->name . "'s Team",
        ]);
    }

    protected function assignType(Business $business) {
        switch ($this->type) {
            case 'service':
                $service = Service::create([]);
                $service->business()->save($business);
                break;
            case 'store':
                $store = Store::create([]);
                $store->business()->save($business);
                break;
            default:
                break;
        }
    }

    public function updated($propertyName) {
        //$this->name = trim($this->name);
        $this->validateOnly($propertyName);
    }

    public function render() {
        return view('livewire.build-and-manage.business.create-new-business');
    }
}