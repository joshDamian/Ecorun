<?php

namespace App\Http\Livewire\Connect\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Profile;

class UpdateProfile extends Component
{
    public $profile;

    use AuthorizesRequests;

    public function mount(Profile $profile) {
        $this->authorize('access', $this->profile);
    }

    public function render() {
        return view('livewire.connect.profile.update-profile');
    }
}