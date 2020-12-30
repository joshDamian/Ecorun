<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Business;
use App\Models\Profile;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BusinessDashboard extends Component
{
    public Profile $profile;
    public Business $business;
    public array $actions = [
        'add-product' => [
            'title' => 'add product',
            'icon' => 'fas fa-plus-circle',
        ],
        'products' => [
            'title' => 'products',
            'icon' => 'fas fa-shopping-basket',
        ],
        'edit' => [
            'title' => 'edit',
            'icon' => 'fas fa-edit',
        ],
        'orders' => [
            'title' => 'orders',
            'icon' => 'fas fa-clipboard-check',
        ],
        'team' => [
            'title' => 'team',
            'icon' => 'fas fa-users',
        ],
    ];
    public string $action_route;
    public array $active_action;
    public $action_route_resource;
    protected $listeners = [
        'setupDone' => '$refresh'
    ];

    public function mount(?string $action_route = 'products', $action_route_resource = null)
    {
        $this->business = $this->profile->loadMissing('profileable')->profileable;
        $this->action_route = (array_key_exists($action_route, $this->actions)) ? $action_route : 'products';
        $this->action_route_resource = ($this->action_route === 'products') ? $action_route_resource : null;
        $this->switchView($this->action_route);
        return;
    }

    public function switchView(string $key)
    {
        $this->action_route = $key;
        $this->active_action = $this->actions[$key];
        return;
    }

    public function render()
    {
        $user = Auth::user()->loadMissing('profile');
        return view('livewire.build-and-manage.business.business-dashboard')->layout('layouts.business', ['user' => $user]);
    }
}
