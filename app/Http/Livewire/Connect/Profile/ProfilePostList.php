<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Post;
use Livewire\Component;
use App\Models\Profile;
use App\Models\User;

/**
 * Class ProfilePostList a component that fetches the posts related to a profile
 */
class ProfilePostList extends Component
{
    public Profile $profile;
    public string $view;
    public int $perPage = 10;
    protected $listeners = [
        //'loadOlderPosts',
        'newPost' => '$refresh'
    ];

    public function loadOlderPosts($count)
    {
        if ($this->count() > (int) $count) {
            $this->perPage = $this->perPage + 5;
        }
    }

    public function mount()
    {
        //
    }
    
    public function render()
    {
        return view(
            'livewire.connect.profile.profile-post-list',
            [
            'posts' => Post::withCount('gallery')->whereIn('profile_id', ($this->view === 'landing-page') ? $this->profile->loadMissing('following')->following->pluck('id') : [$this->profile->id])
                ->latest()->get()->unique()->loadMissing('gallery', 'likes', 'profile')
            ]
        );
    }
}
