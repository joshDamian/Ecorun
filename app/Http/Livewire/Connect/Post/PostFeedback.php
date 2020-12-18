<?php

namespace App\Http\Livewire\Connect\Post;

use App\Http\Livewire\Traits\HasFeedback;
use App\Http\Livewire\Traits\HasLikes;
use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostFeedback extends Component
{
    use HasLikes;
    use HasFeedback;

    public $postId;
    public $view;
    protected $listeners = [
        'newFeedback' => '$refresh',
        'newLike' => '$refresh'
    ];
   
    public function mount()
    {
        $this->profile = Auth::user()->currentProfile;
        $this->likeable = $this->post;
        $this->feedbackReady = ($this->view === 'post.show') ? true : null;
    }

    public function getPostProperty()
    {
        return Post::find($this->postId);
    }

    public function render()
    {
        return view(
            'livewire.connect.post.post-feedback',
            [
            'likes_count' => $this->likes()
            ]
        );
    }
}
