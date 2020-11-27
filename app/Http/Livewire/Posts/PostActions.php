<?php

namespace App\Http\Livewire\Posts;

use Livewire\Component;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostActions extends Component
{
    public $user;
    public $postId;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function getPostProperty()
    {
        return Post::find($this->postId);
    }

    public function like()
    {
        if ($this->liked()) {
            $this->post->likes()->where('profile_id', $this->user->profile->id)->first()->delete();
        } else {
            $like = new Like();
            $like->profile_id = $this->user->profile->id;
            $this->post->likes()->save($like);
        }
    }

    public function liked()
    {
        return $this->post->likes->pluck('profile')->contains($this->user->profile);
    }

    public function render()
    {
        return view('livewire.posts.post-actions', [
            'like_count' => $this->post->likes->count(),
        ]);
    }
}
