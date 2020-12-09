<?php

namespace App\Http\Livewire\Connect\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Profile;

class UpdateCurrentProfile extends Component
{
    use AuthorizesRequests;

    public function mount($tag) {
        $this->authorize('update', Profile::where('tag', $tag)->firstOrFail());
    }

    public function render() {
        return view('livewire.connect.profile.update-current-profile', [
            'currentProfile' => Auth::user()->currentProfile
        ]);
    }
}