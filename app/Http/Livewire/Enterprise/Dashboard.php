<?php

namespace App\Http\Livewire\Enterprise;

use App\Models\Enterprise;
use Livewire\Component;

class Dashboard extends Component
{
    public $enterprise;
    protected $listeners = [
        'displayEnterpriseDashboard'
    ];

    public function displayEnterpriseDashboard(Enterprise $enterprise)
    {
        $this->enterprise = $enterprise;
    }

    public function render()
    {
        return view('livewire.enterprise.dashboard');
    }
}
