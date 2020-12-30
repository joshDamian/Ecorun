<?php

namespace App\Http\Livewire\Connect\ProfileDashboard;

use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;

class BusinessProfileData extends Component
{
    use WithPagination;

    public Profile $profile;
    public array $active_view;
    public string $action_route;
    public array $views = [
        'products' => [
            'title' => 'products',
            'icon' => 'fas fa-shopping-bag',
        ],
        'posts' => [
            'title' => 'posts',
            'icon' => 'fa fa-user-edit'
        ],
        'gallery' => [
            'title' => 'gallery',
            'icon' => 'far fa-images'
        ],
        'about' => [
            'title' => 'about',
            'icon' => 'fas fa-store-alt'
        ],
    ];

    public function mount(string $action_route = 'products'):void
    {
        $this->action_route = $action_route;
        if (!array_key_exists($this->action_route, $this->views)) {
            $this->action_route = 'products';
        }
        $this->switchView($this->action_route);
        return;
    }

    public function switchView(string $view_key)
    {
        $this->active_view = $this->views[$view_key];
        return;
    }


    public function render()
    {
        return view(
            'livewire.connect.profile-dashboard.business-profile-data'
        );
    }
}
