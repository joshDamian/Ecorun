<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Service;
use App\Models\Store;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\Profile;
use Illuminate\Validation\Rule;
use App\Traits\StringManipulations;

class CreateNewBusiness extends Component
{
    use StringManipulations;

    public $name;
    public $type;

    public function create() {
        $this->name = trim($this->name);
        $this->validate($this->rules());

        $this->name = ucwords($this->name);

        $business = Auth::user()->isManager
        ->businesses()->save(new Business());

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
        $name_slug = $this->data_slug('name');

        $business->profile()->create([
            'name' => $this->name,
            'tag' => (is_object(Profile::where('tag', $name_slug)->get()->first())) ? null : $name_slug,
            'description' => ($business->isStore()) ?
            "{$this->name} sells quality products, we look forward to satisfying your purchase needs." :
            "{$this->name} offers quality services, we look forward to making you happy."
        ]);

        $business->profile->following()->save($business->profile);
    }

    public function slugData() {
        return [
            'name' => $this->name,
        ];
    }

    public function rules(): array {
        return  [
            'name' => [
                'required',
                Rule::unique('profiles', 'name')->where(function ($query) {
                    return $query->where('profileable_type', 'App\Models\Business');
                }),
                'min:4',
                'max:255',
            ],

            'type' => 'required'
        ];
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
        $this->validateOnly(
            $propertyName,
            $this->rules()
        );
    }

    public function render() {
        return view('livewire.build-and-manage.business.create-new-business');
    }
}