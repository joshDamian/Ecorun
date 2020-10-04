<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class ActionView extends Component
{
    protected $listeners = [
        'dashboard_actionSwitch'
    ];

    public $activeView;

    public function mount()
    {
        $this->activeView = [
            'title' => 'view orders',
            'icon-class' => 'fa fa-shopping-bag',
        ];
    }

    public function dashboard_actionSwitch($action)
    {
        $this->activeView = $action;
    }

    public function render()
    {
        return view('livewire.dashboard.action-view');
    }
}
