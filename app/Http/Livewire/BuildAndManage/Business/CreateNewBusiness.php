<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use Livewire\Component;
use App\Models\Business;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Traits\StringManipulations;

class CreateNewBusiness extends Component
{
    use StringManipulations;

    public User $user;
    public $name;
    public $type = ['store'];
    protected $validTypes = ['store', 'service'];

    public function create()
    {
        $this->name = trim($this->name);
        $this->validate($this->rules());
        $manager_access = $this->user->is_business_owner;

        $this->name = ucwords($this->name);
        $business = $this->user->businesses()->create(
            ['type' => $this->type]
        );
        if (!$manager_access) {
            $manager_access = $this->user->is_business_owner = true;
            $this->user->save();
        }
        if ($business) {
            $team = $this->createTeam();
            $this->create_profile($business);
        }
        $this->emitSelf('created');
        $this->emit('newBusiness');
        return $business->team()->save($team);
    }

    protected function create_profile(Business $business)
    {
        $name_slug = $this->data_slug('name');

        $business->profile()->create([
            'name' => $this->name,
            'tag' => (Profile::where('tag', $name_slug)->exists()) ? null : $name_slug,
            'description' => ($business->isStore()) ?
                "{$this->name} sells quality products, we look forward to satisfying your purchase needs." :
                "{$this->name} offers quality services, we look forward to making you happy."
        ]);
    }

    public function slugData()
    {
        return [
            'name' => $this->name,
        ];
    }

    public function rules(): array
    {
        return  [
            'name' => [
                'required',
                Rule::unique('profiles', 'name')->where(function ($query) {
                    return $query->where('profileable_type', Business::class);
                }),
                'min:4',
                'max:255',
            ],

            'type' => ['required', Rule::in($this->validTypes)]
        ];
    }

    protected function createTeam()
    {
        return $this->user->ownedTeams()->create([
            'name' => $this->name . "'s Team",
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly(
            $propertyName,
            $this->rules()
        );
    }

    public function render()
    {
        return view('livewire.build-and-manage.business.create-new-business');
    }
}
