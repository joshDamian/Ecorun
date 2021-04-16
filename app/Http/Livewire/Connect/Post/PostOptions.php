<?php

namespace App\Http\Livewire\Connect\Post;

use Livewire\Component;
use App\Models\Post;
use App\Http\Livewire\Traits\HasBookmarks;
use App\Http\Livewire\Traits\HasFollowing;
use Illuminate\Support\Facades\Auth;

class PostOptions extends Component
{
    use HasBookmarks,
        HasFollowing;

    public Post $post;

    public function mount()
    {
        $this->bookmarkable = $this->post;
        $this->followable = $this->post->profile;
        if (Auth::check()) {
            $this->profile = Auth::user()->currentProfile;
            $this->bookmarked = $this->bookmarked();
            $this->follows = $this->follows();
        }
    }

    public function getListeners()
    {
        return [
            'options_refresh.' . $this->post->id . 'App.Models.Post' => '$refresh'
        ];
    }

    public function render()
    {
        return view('livewire.connect.post.post-options');
    }
}
