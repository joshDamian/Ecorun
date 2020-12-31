<?php

namespace App\Http\Livewire\Connect\Profile;

use Livewire\Component;
use App\Models\Profile;

/**
* Class ProfilePostList a component that fetches the posts related to a profile
*/
class ProfilePostList extends Component
{
    public Profile $profile;
    public string $view;
    public int $perPage = 10;
    public $posts_lazy;
    protected $listeners = [
        //'loadOlderPosts',
        'newPost'
    ];

    public function loadOlderPosts() {
        $this->perPage = $this->perPage + 5;
    }

    public function newPost() {
        $this->posts_lazy = ($this->view === 'landing-page') ? $this->profile->feed() : $this->profile->posts->loadMissing('gallery', 'likes', 'profile')->loadCount('gallery');
    }

    public function mount() {
        $this->posts_lazy = ($this->view === 'landing-page') ? $this->profile->feed() : $this->profile->posts->loadMissing('gallery', 'likes', 'profile')->loadCount('gallery');
    }

    public function render() {
        return view(
            'livewire.connect.profile.profile-post-list',
            [
                'posts' => $this->posts_lazy->take($this->perPage)
            ]
        );
    }
}