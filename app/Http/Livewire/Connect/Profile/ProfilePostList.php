<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Post;
use Livewire\Component;
use App\Models\Profile;
use Livewire\WithPagination;

class ProfilePostList extends Component
{
    //use WithPagination;

    public Profile $profile;
    public $view;
    public $perPage = 10;
    public $readyToLoad = false;
    protected $listeners = [
        'loadOlderPosts',
        'newPost' => '$refresh'
    ];

    public function loadPosts() {
        $this->readyToLoad = true;
    }

    public function loadOlderPosts() {
        $this->perPage = $this->perPage + 5;
    }

    public function render() {
        return view('livewire.connect.profile.profile-post-list', [
            'posts' => $this->readyToLoad ? Post::without('profile.followers')->whereIn('profile_id', ($this->view === 'landing-page') ? $this->profile->following->pluck('id') : [$this->profile->id])
            ->latest()->paginate($this->perPage) : []
        ]);
    }
}