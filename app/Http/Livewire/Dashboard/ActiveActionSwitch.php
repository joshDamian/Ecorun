<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class ActiveActionSwitch extends Component
{
    public $actions = [
        'orders' => [
            'title' => 'view orders',
            'icon-class' => 'fa fa-shopping-bag',
        ],

        'manager dashboard' => [
            'title' => 'manager dashboard',
            'icon-class' => 'fa fa-tools',
        ],

        'cart' => [
            'title' => 'cart',
            'icon-class' => 'fa fa-shopping-cart'
        ],

        'play' => [
            'title' => 'test action',
            'icon-class' => 'fa fa-play'
        ]
    ];

    public $activeClass =
    "inline-block border rounded-full py-1 px-3 border-blue-500 bg-blue-500 hover:bg-blue-700 text-white";

    public $inActiveClass =
    "inline-block border rounded-full py-1 px-3 border-whitehover:border-gray-200 text-blue-500 hover:bg-gray-200";

    public $activeAction;

    public function mount()
    {
        $this->activeAction = $this->actions['orders'];
    }

    public function switchAction($action)
    {
        $this->activeAction = $this->actions[$action];
        $this->emit('activeActionSwitch', $this->activeAction);
    }

    public function render()
    {
        return view('livewire.dashboard.active-action-switch');
    }
}
