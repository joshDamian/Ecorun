<?php

namespace App\Http\Livewire\Enterprise;

use App\Models\Enterprise;
use Livewire\Component;

class Dashboard extends Component
{
    public $enterprise;
    protected $listeners = [
        'displayDashboard',
    ];

    public function displayDashboard(Enterprise $enterprise) {
        $this->enterprise = $enterprise;
        $this->emit('displayReady');
    }

    public function render() {
        return view('livewire.enterprise.dashboard');
    }
}