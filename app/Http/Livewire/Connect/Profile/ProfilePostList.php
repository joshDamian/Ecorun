<?php

namespace App\Http\Livewire\Connect\Profile;

use Livewire\Component;
use App\Models\Profile;

class ProfilePostList extends Component
{
    public Profile $profile;
    public string $view;
    public int $perPage = 10;
    protected $listeners = [
        'newPost' => '$refresh'
    ];

    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
    }

    public function posts_count()
    {
        return $this->posts_lazy->count();
    }

    public function getPostsLazyProperty()
    {
        return collect([$this->profile->posts->loadMissing('gallery', 'likes', 'profile')->loadCount('gallery'), $this->profile->loadMissing('shares')->shares])->flatten()->unique()->sortByDesc('updated_at');
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
