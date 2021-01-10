<?php

namespace App\Http\Livewire\Connect\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UpdateProfile extends Component
{
    public $profile;

    use AuthorizesRequests;

    public function mount() {
        $this->authorize('access', $this->profile);
    }

    public function render() {
        $user = Auth::user()->loadMissing('profile');
        return view('livewire.connect.profile.update-profile')->layout('layouts.business', ['user' => $user]);
    }
}