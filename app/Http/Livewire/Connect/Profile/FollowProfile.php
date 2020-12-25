<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Http\Controllers\FollowController;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowProfile extends Component
{
    public Profile $profile;

    public function follow() {
        $followController = new FollowController();
        $followController->store($this->profile, request());
        return $this->emit('modifiedFollowers');
    }

    public function isFollowing() {
        if (Auth::user()) {
            return Auth::user()->currentProfile->following()->where('profile_id', $this->profile->id)->get()->first() !== null;
        } else {
            return false;
        }
    }

    public function render() {
        return view('livewire.connect.profile.follow-profile');
    }
}