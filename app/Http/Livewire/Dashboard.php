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

    public function mount($active_action = null)
    {
        $this->active_action = ($active_action) ?
            ((array_key_exists($active_action, $this->actions)) ? $this->actions[$active_action] : $this->actions['orders'])
            : $this->actions['manager account'];
    }

    public function switchAction($key)
    {
        $this->active_action = $this->actions[$key];
        $this->emit('actionSwitch', $key);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
