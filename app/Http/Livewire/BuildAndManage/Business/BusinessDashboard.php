<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Business;
use Livewire\Component;

class BusinessDashboard extends Component
{
    public Business $business;

    public array $actions = [
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
            'icon' => 'fas fa-clipboard-check',
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

    public $action_route;

    public array $active_action;

    public $action_route_resource;

    protected $listeners = [
        'setupDone' => '$refresh'
    ];

    public function mount($action_route = null, $action_route_resource = null)
    {
        $this->action_route = $action_route;
        $this->action_route_resource = $action_route_resource;

        if (!array_key_exists($this->action_route, $this->actions)) {
            $this->action_route = 'products';
        }
        if ($this->action_route === 'products') {
            $this->action_route_resource = $action_route_resource;
        }

        return $this->active_action = $this->actions[$this->action_route];
    }

    public function switchAction($key)
    {
        $this->action_route = $key;
        $this->active_action = $this->actions[$key];
    }

    public function render()
    {
        return view('livewire.build-and-manage.business.business-dashboard')->layout('layouts.business');
    }
}
