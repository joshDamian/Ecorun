<?php

namespace App\Http\Livewire\Connect\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Profile;

class UpdateProfile extends Component
{
    public $tag;
    public $profile;

    use AuthorizesRequests;

    public function mount($tag) {
        $this->tag = $tag;
        $this->profile = Profile::where('tag', $this->tag)->orWhere('initial_tag', $tag)->firstOrFail();
        $this->authorize('access', $this->profile);
    }

    public function render() {
        return view('livewire.connect.profile.update-profile');
    }
}