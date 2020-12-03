<?php

namespace App\Http\Livewire\Connect\Post;

use App\Http\Livewire\Connect\Traits\HasComments;
use App\Http\Livewire\Connect\Traits\HasLikes;
use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostFeedback extends Component
{
    use HasLikes;
    use HasComments;

    public $postId;
    public $view;

    public function mount()
    {
        $this->profile = Auth::user()->profile;
        $this->likeable = $this->post;
        $this->commentsReady = ($this->view === 'post.show') ? true : null;
    }

    public function getPostProperty()
    {
        return Post::find($this->postId);
    }

    public function render()
    {
        return view('livewire.connect.post.post-feedback', [
            'likes_count' => $this->likes()
        ]);
    }
}
