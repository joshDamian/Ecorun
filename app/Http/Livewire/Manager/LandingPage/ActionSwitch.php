<?php

namespace App\Http\Livewire\Manager\LandingPage;

use Livewire\Component;

class ActionSwitch extends Component
{
    public $actions = [
        'manage enterprises',
        'create new enterprise',
        'test action-1',
        'test action -2',
    ];

    public $activeClass =
    "inline-block border cursor-pointer rounded-md py-1 px-3 border-blue-700 bg-blue-700 hover:bg-blue-900 text-white";

    public $inActiveClass =
    "inline-block border cursor-pointer rounded-md py-1 px-3 border-blue-700 hover:border-blue-700 hover:text-white text-blue-500 hover:bg-blue-700";


    public $activeAction;

    public function mount()
    {
        $this->activeAction = "manage enterprises";
    }

    public function switchAction($action)
    {
        $this->activeAction = $action;
        $this->emit(
            'manager_landingPage_actionSwitch',
            $this->activeAction
        );
    }

    public function render()
    {
        return view('livewire.manager.landing-page.action-switch');
    }
}
