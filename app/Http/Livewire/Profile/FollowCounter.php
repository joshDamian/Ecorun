<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FollowCounter extends Component
{
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
        $this->following = Auth::user()->following->count();
        $this->followers = Auth::user()->profile->followers->count();
    }

    public function render()
    {
        return view('livewire.profile.follow-counter');
    }
}
