<?php

namespace App\Http\Livewire\Connect\Post;

use Livewire\Component;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostFeedback extends Component
{
    public $user;
    public $postId;
    public $commentsReady = false;

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

    public function displayComments()
    {
        $this->commentsReady = !$this->commentsReady;
    }

    public function render()
    {
        return view('livewire.connect.post.post-feedback', [
            'like_count' => $this->post->likes->count(),
        ]);
    }
}
