<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Business;
use App\Models\Profile;
use Livewire\Component;

class BusinessDashboard extends Component
{
    public $tag;
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
        'gallery' => [
            'title' => 'gallery',
            'icon' => 'fas fa-image',
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

    public function mount($action_route = 'products', $action_route_resource = null)
    {
        $this->action_route = (array_key_exists($action_route, $this->actions)) ? $action_route : 'products';
        $this->action_route_resource = ($this->action_route === 'products') ? $action_route_resource : null;
        $this->switchAction($this->action_route);
        return;
    }

    public function getBusinessProperty(): Business
    {
        return Business::findOrFail(Profile::where('tag', $this->tag)->firstOrFail()->loadMissing('profileable')->profileable->id);
    }

    public function switchAction(string $key)
    {
        $this->action_route = $key;
        $this->active_action = $this->actions[$key];
        return;
    }

    public function render()
    {
        return view('livewire.build-and-manage.business.business-dashboard')->layout('layouts.business');
    }
}
