<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Post;
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
        'newPost' => '$refresh'
    ];

    public function loadOlderPosts()
    {
        $this->perPage = $this->perPage + 5;
    }

    public function mount()
    {
        $all_posts = ($this->view === 'landing-page') ? true : false;
        $this->posts_lazy = Post::with('gallery', 'likes', 'profile')->withCount('gallery')->whereIn('profile_id', ($all_posts) ? $this->profile->loadMissing('following')->following->pluck('id') : [$this->profile->id])
            ->latest()->get()->unique();
    }

    public function render()
    {
        return view(
            'livewire.connect.profile.profile-post-list',
            [
            'posts' => $this->posts_lazy->take($this->perPage)
            ]
        );
    }
}
