<?php

namespace App\Http\Livewire\BuildAndManage\Manager;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManagerBusinessList extends Component
{
    protected $listeners = [
        'newBusiness' => '$refresh'
    ];

    public function render()
    {
        $businesses = Auth::user()->isManager->businesses;
        return view('livewire.build-and-manage.manager.manager-business-list', [
            'businesses' => $businesses,
            'businesses_count' => $businesses->count()
        ]);
    }
}
