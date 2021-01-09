<?php

namespace App\Http\Livewire\Connect\Profile;

use Livewire\Component;

class FollowingFollowersCounter extends Component
{
    public $profile;
    public $following;
    public $followers;
    protected $listeners = [
        'modifiedFollowers' => 'count'
    ];

    public function mount()
    {
        return $this->count();
    }

    public function count()
    {
        $this->following = $this->profile->following->count();
        $this->followers = $this->profile->followers->count();
    }

    public function render()
    {
        return view('livewire.connect.profile.following-followers-counter');
    }
}
