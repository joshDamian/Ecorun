<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Connect\Profile\Badge;
use Livewire\Component;
use App\Models\Build\Business\Business;
use App\Models\Connect\Profile\Profile;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Traits\StringManipulations;

class CreateNewBusiness extends Component
{
    use StringManipulations;

    public User $user;
    public $name;
    public Badge $primaryBadge;

    public function create()
    {
        $this->name = trim($this->name);
        $this->validate($this->rules());
        $manager_access = $this->user->is_business_owner;

        $this->name = ucwords($this->name);
        $business = $this->user->businesses()->create(
            [
                'primary_badge_id' => $this->primaryBadge->id
            ]
        );
        $business->badges()->attach($this->primaryBadge->id);
        if (!$manager_access) {
            $this->user->is_business_owner = true;
        }
        $business_owner_badge = Badge::firstWhere(function ($query) {
            $query->where('label', 'business owner')->where('canuse', 'user');
        });
        if ($this->user->badges()->where('label', 'business owner')->where('canuse', 'user')->exists()) {
            $this->user->primary_badge_id = $business_owner_badge->id;
        } else {
            $this->user->badges()->attach($business_owner_badge->id);
            $this->user->primary_badge_id = $business_owner_badge->id;
        }
        if ($business) {
            $team = $this->createTeam();
            $this->create_profile($business);
        }
        $this->emitSelf('created');
        $this->emit('newBusiness');
        $this->user->save();
        $this->user->flushQueryCache();
        return $business->team()->save($team);
    }

    protected function create_profile(Business $business)
    {
        $name_slug = $this->data_slug('name');

        $business->profile()->create([
            'name' => $this->name,
            'tag' => (Profile::where('tag', $name_slug)->exists()) ? null : $name_slug,
            'description' => "{$this->name} sells quality products and services, and looks forward to satisfying your purchase needs."
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
            'primaryBadge.label' => ['required', Rule::exists('badges', 'label')->where(function ($query) {
                $query->where('canuse', 'business');
            })]
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
        $this->validateOnly($propertyName, $this->rules());
    }

    public function mount()
    {
        $this->primaryBadge = (new Business())->getDefaultBadge();
    }

    public function render()
    {
        return view('livewire.build-and-manage.business.create-new-business');
    }
}
