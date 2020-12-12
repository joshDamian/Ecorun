<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Post;
use Livewire\Component;
use App\Models\Profile;
use Illuminate\Support\Facades\Cache;

class ProfilePostList extends Component
{
    public Profile $profile;
    public $activePost;
    public $view;
    public $displayOptions;
    public $readyToLoad = false;
    protected $listeners = [
        'newPost' => 'refreshPosts'
    ];

    public function mount () {
        $this->refreshPosts();
    }

    public function loadPosts() {
        return $this->readyToLoad = true;
    }

    public function triggerOptions(Post $post) {
        $this->activePost = $post;
        return $this->displayOptions = true;
    }

    public function freshPosts() {
        return Post::without('profile.followers')->whereIn('profile_id', ($this->view === 'landing-page') ? $this->profile->following->pluck('id') : [$this->profile->id])->whereNotIn('id', $this->cachedPosts()->pluck('id'))->latest()->get();
    }

    public function refreshPosts() {
        Cache::put(
            $this->cacheKey(),
            $this->getPosts()
        );
    }

    public function cacheKey() {
        return "profile_posts_" . $this->profile->id;
    }

    public function getPosts() {
        return Post::without('profile.followers')->whereIn('profile_id', ($this->view === 'landing-page') ? $this->profile->following->pluck('id') : [$this->profile->id])->latest()->get();
    }

    public function cachedPosts() {
        return Cache::rememberForever($this->cacheKey(), function () {
            return $this->getPosts();
        });
    }

    public function checkForUpdates() {
        //
    }

    public function hasNewItem() {
        return $this->freshPosts()->count() > 0;
    }

    public function render() {
        return view('livewire.connect.profile.profile-post-list', [
            'posts' => $this->readyToLoad ?
            $this->cachedPosts()->sortDesc()->values()->all() : []
        ]);
    }
}