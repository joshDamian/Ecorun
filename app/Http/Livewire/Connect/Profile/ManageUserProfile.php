<?php

namespace App\Http\Livewire\Connect\Profile;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageUserProfile extends Component
{
    protected $listeners = [
        'contactsModified' => '$refresh'
    ];

    public function render(Request $request)
    {
        return view('livewire.connect.profile.manage-user-profile', [
            'request' => $request,
            'user' => Auth::user()
        ]);
    }
}
