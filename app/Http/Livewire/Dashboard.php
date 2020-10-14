<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $actions = [
        'orders' => [
            'title' => 'orders',
            'icon' => 'fas fa-shopping-bag',
            'color' => 'pink-500',
        ],

        'cart' => [
            'title' => 'cart',
            'icon' => 'fas fa-shopping-cart',
            'color' => 'purple-500'
        ],

        'manager account' => [
            'title' => 'manager account',
            'icon' => 'fas fa-user-tie',
            'color' => 'blue-600'
        ],

        'messages' => [
            'title' => 'messages',
            'icon' => 'fas fa-envelope',
            'color' => 'red-500'
        ]
    ];

    public $active_action;

    public function mount()
    {
        $this->active_action = $this->actions['manager account'];
    }

    public function switchAction($key)
    {
        $this->active_action = $this->actions[$key];
        $this->emit('actionSwitch');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
