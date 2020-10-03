<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class ActiveView extends Component
{
    protected $listeners = [
        'activeActionSwitch'
    ];

    public $activeView;

    public function mount()
    {
        $this->activeView = [
            'title' => 'view orders',
            'icon-class' => 'fa fa-shopping-bag',
        ];
    }

    public function activeActionSwitch($action)
    {
        $this->activeView = $action;
    }

    public function render()
    {
        return view('livewire.dashboard.active-view');
    }
}
