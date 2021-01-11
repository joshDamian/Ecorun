<?php

namespace App\Http\Livewire\BuildAndManage\Manager;

use Livewire\Component;
use App\Models\User;

class ManagerBusinessList extends Component
{
    public User $user;
    protected $listeners = [
        'newBusiness' => '$refresh'
    ];

    public function render()
    {
        $businesses = $this->user->loadMissing('businesses')->businesses;
        return view('livewire.build-and-manage.manager.manager-business-list', [
            'businesses' => $businesses,
            'businesses_count' => $businesses->count()
        ]);
    }
}
