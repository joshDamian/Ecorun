<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Http\Controllers\FollowController;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowProfile extends Component
{
    public Profile $profile;
    protected $listeners = [
        'modifiedFollowers' => '$refresh'
    ];

    public function follow() {
        (new FollowController())->store($this->profile, request());
        return $this->emit('modifiedFollowers');
    }

    public function isFollowing() {
        if (Auth::check()) {
            return Auth::user()->currentProfile->loadMissing('following')->following->contains($this->profile);
        } else {
            return false;
        }
    }

    public function render() {
        return view('livewire.connect.profile.follow-profile');
    }
}