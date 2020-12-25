<?php

namespace App\Http\Livewire\Connect\ProfileDashboard;

use App\Models\User;
use Livewire\Component;

class UserProfileData extends Component
{
    public User $user;
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

    public function mount($action_route = 'posts')
    {
        $this->action_route = (array_key_exists($this->action_route, $this->views)) ? $action_route : 'posts';
        $this->switchView($this->action_route);
        return;
    }

    public function switchView($view_key)
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
