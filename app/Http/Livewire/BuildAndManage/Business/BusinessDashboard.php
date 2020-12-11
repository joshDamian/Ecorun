<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Business;
use Illuminate\Http\Request;
use Livewire\Component;

class BusinessDashboard extends Component
{
    public Business $business;

    public $actions = [
        'add-product' => [
            'title' => 'add product',
            'icon' => 'fas fa-plus-circle',
            'color' => 'green-500'
        ],

        'products' => [
            'title' => 'products',
            'icon' => 'fas fa-shopping-basket',
            'color' => 'purple-500'
        ],

        'orders' => [
            'title' => 'orders',
            'icon' => 'fas fa-shopping-bag',
            'color' => 'pink-500'
        ],

        'gallery' => [
            'title' => 'gallery',
            'icon' => 'fas fa-image',
            'color' => 'teal-500'
        ],

        'team' => [
            'title' => 'management team',
            'icon' => 'fas fa-users',
            'color' => 'yellow-500'
        ],


    ];

    public $active_action;

    protected $listeners = [
        'setupDone' => '$refresh'
    ];

    public function mount($active_action = null)
    {
        $this->active_action = ($active_action) ?
            ((array_key_exists($active_action, $this->actions)) ? $this->actions[$active_action] : $this->actions['add-product'])
            : $this->actions['products'];
    }

    public function switchAction($key)
    {
        $this->active_action = $this->actions[$key];
        $this->emit('actionSwitch', $key);
    }

    public function render()
    {
        return view('livewire.build-and-manage.business.business-dashboard');
    }
}
