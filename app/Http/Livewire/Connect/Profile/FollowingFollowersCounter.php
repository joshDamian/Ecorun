<?php

namespace App\Http\Livewire\Connect\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class FollowingFollowersCounter extends Component
{
    public $profile;
    public $following;
    public $followers;
    protected $listeners = [
        'modifiedFollowers' => 'count'
    ];

    public function mount() {
        return $this->count();
    }

    public function count() {
        $self_following = Cache::rememberForever("self_following_" . $this->profile->id, function () {
            return $this->profile->following->contains($this->profile);
        });

        $following_count = $this->profile->following->count();
        $followers_count = $this->profile->followers->count();

        $this->following = $self_following ? ($following_count - 1) : $following_count;
        $this->followers = $self_following ? ($followers_count - 1) : $followers_count;
    }

    public function render() {
        return view('livewire.connect.profile.following-followers-counter');
    }
}