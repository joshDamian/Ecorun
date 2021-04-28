<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Build\Business\Business;
use App\Models\Connect\Profile\Profile;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BusinessDashboard extends Component
{
    public Profile $profile;
    public Business $business;
    public User $user;
    public array $actions = [
        'sell' => [
            'title' => 'sell',
            'icon' => 'fas fa-plus-circle',
        ],
        'warehouse' => [
            'title' => 'warehouse',
            'icon' => 'fas fa-warehouse',
        ],
        'edit' => [
            'title' => 'edit',
            'icon' => 'far fa-edit',
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

    public function mount(?string $action_route = 'warehouse', $action_route_resource = null)
    {
        $this->user = Auth::user()?->loadMissing('profile');
        $this->business = $this->profile->loadMissing('profileable')->profileable;
        $this->action_route = (array_key_exists($action_route, $this->actions)) ? $action_route : 'warehouse';
        $this->action_route_resource = ($this->action_route === 'warehouse') ? $action_route_resource : null;
        $this->switchView($this->action_route);
        return;
    }

    public function switchView(string $key)
    {
        $this->action_route = $key;
        $this->active_action = $this->actions[$key];
    }

    public function render()
    {
        return view('livewire.build-and-manage.business.business-dashboard')->layout('layouts.business', ['user' => $this->user]);
    }
}
