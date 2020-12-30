<?php

namespace App\Http\Livewire\Connect\ProfileDashboard;

use App\Models\Profile;
use Livewire\Component;

class UserProfileData extends Component
{
    public Profile $profile;
    public array $active_view;
    public string $action_route;
    public array $views = [
        'posts' => [
            'title' => 'posts',
            'icon' => 'fas fa-user-edit'
        ],
        'gallery' => [
            'title' => 'gallery',
            'icon' => 'fas fa-images'
        ],
        'about' => [
            'title' => 'about',
            'icon' => 'fas fa-user'
        ]
    ];

    public function mount(string $action_route = 'posts'):void
    {
        $this->action_route = (array_key_exists($this->action_route, $this->views)) ? $action_route : 'posts';
        $this->switchView($this->action_route);
        return;
    }

    public function switchView(string $view_key):void
    {
        $this->action_route = $view_key;
        $this->active_view = $this->views[$view_key];
        return;
    }

    public function render()
    {
        return view('livewire.connect.profile-dashboard.user-profile-data');
    }
}
