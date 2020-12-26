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

    public Post $post;
    public string $view;
    protected $listeners = [
        'newFeedback' => '$refresh',
        'newLike' => '$refresh'
    ];
   
    public function mount():void
    {
        $this->profile = Auth::user()->loadMissing('currentProfile')->currentProfile;
        $this->likeable = $this->post;
        $this->feedbackReady = ($this->view === 'post.show') ? true : null;
        return;
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
