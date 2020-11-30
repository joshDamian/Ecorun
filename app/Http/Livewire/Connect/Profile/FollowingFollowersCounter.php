<?php

namespace App\Http\Livewire\Connect\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FollowingFollowersCounter extends Component
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
        $self_following = Cache::rememberForever("self_following_" . Auth::user()->id, function () {
            return Auth::user()->following->contains(Auth::user()->profile->id);
        });

        $following_count = Auth::user()->following->count();
        $followers_count = Auth::user()->profile->followers->count();

        $this->following = $self_following ? ($following_count - 1) : $following_count;
        $this->followers = $self_following ? ($followers_count - 1) : $followers_count;
    }

    public function render()
    {
        return view('livewire.connect.profile.following-followers-counter');
    }
}
