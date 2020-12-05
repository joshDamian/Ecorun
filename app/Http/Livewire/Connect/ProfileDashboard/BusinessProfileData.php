<?php

namespace App\Http\Livewire\Connect\ProfileDashboard;

use Livewire\Component;

class BusinessProfileData extends Component
{
    public $business;
    public $active_view;
    public $views = [
        'products' => [
            'title' => 'products',
            'icon' => 'fas fa-shopping-bag',
        ],

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
            'icon' => 'fas fa-store-alt'
        ],
    ];

    public function mount($active_view = null)
    {
        if ($active_view) {
            if (array_key_exists($active_view, $this->views)) {
                $this->switchView($active_view);
            } else {
                $this->defaultView();
            }
        } else {
            $this->defaultView();
        }
    }

    public function switchView($view_key)
    {
        return $this->active_view = $this->views[$view_key];
    }

    public function defaultView()
    {
        return $this->switchView('products');
    }

    public function render()
    {
        return view('livewire.connect.profile-dashboard.business-profile-data');
    }
}
