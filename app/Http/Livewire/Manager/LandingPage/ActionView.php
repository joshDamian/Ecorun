<?php

namespace App\Http\Livewire\Manager\LandingPage;

use Livewire\Component;

class ActionView extends Component
{
    public $activeView;
    protected $listeners = [
        'manager_landingPage_actionSwitch'
    ];

    public function manager_landingPage_actionSwitch($action)
    {
        $this->activeView = $action;
    }

    public function mount()
    {
        $this->activeView = "manage enterprises";
    }

    public function render()
    {
        return view('livewire.manager.landing-page.action-view');
    }
}
