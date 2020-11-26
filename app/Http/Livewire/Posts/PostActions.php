<?php

namespace App\Http\Livewire\Posts;

use Livewire\Component;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostActions extends Component
{
    public $user;
    public $post;

    public function mount()
    {
        return $this->user = Auth::user();
    }

    public function like()
    {
        $liked = $this->post->likes->pluck('profile')->contains($this->user->profile);
        if ($liked) {
            return $this->post->likes()->where('profile_id', $this->user->profile->id)->delete();
        } else {
            $like = new Like();
            $like->profile_id = $this->user->profile->id;
            return $this->post->likes()->save($like);
        }
    }

    public function render()
    {
        return view('livewire.posts.post-actions', [
            'like_count' => $this->post->likes->count(),
            'liked' => $this->post->likes->pluck('profile')->contains($this->user->profile),
        ]);
    }
}
