<?php

namespace App\Http\Livewire\Profile;

use App\Models\Profile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Follow extends Component
{
    //use AuthorizesRequests;

    public Profile $profile;

    public function follow()
    {
        if (Auth::user()) {
            if (!Auth::user()->can('update', $this->profile)) {
                Auth::user()->following()->toggle($this->profile);
                return $this->emit('modifiedFollowers');
            }
        } else {
            redirect()->to('/login');
        }
    }

    public function isFollowing()
    {
        if (Auth::user()) {
            return Auth::user()->following()->where('profile_id', $this->profile->id)->get()->first() !== null;
        } else {
            return false;
        }
    }

    public function render()
    {
        return view('livewire.profile.follow');
    }
}
