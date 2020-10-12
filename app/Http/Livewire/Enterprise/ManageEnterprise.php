<?php

namespace App\Http\Livewire\Enterprise;

use App\Models\Enterprise;
use Livewire\Component;

class ManageEnterprise extends Component
{
    public Enterprise $enterprise;

    public $actions = [
        'add product' => [
            'title' => 'add product',
            'icon' => 'fas fa-plus-circle',
            'color' => 'green-500'
        ],

        'products' => [
            'title' => 'products',
            'icon' => 'fas fa-shopping-basket',
            'color' => 'purple-500'
        ],

        'update business info' => [
            'title' => 'update business info',
            'icon' => 'fas fa-edit',
            'color' => 'red-500'
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

    ];

    public $active_action;

    public function mount()
    {
        $this->active_action = $this->actions['add product'];
    }

    public function switchAction($key)
    {
        $this->active_action = $this->actions[$key];
    }

    public function render()
    {
        return view('livewire.enterprise.manage-enterprise');
    }
}
