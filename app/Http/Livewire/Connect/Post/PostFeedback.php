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
    public $likes_count;
    protected $listeners = [
        'newFeedback' => '$refresh',
        'newLike' => 'count'
    ];
   
    public function mount():void
    {
        $this->profile = Auth::user()->loadMissing('currentProfile')->currentProfile;
        $this->likeable = $this->post;
        $this->likes_count = $this->likes();
        $this->feedbackReady = ($this->view === 'post.show') ? true : null;
        return;
    }

    public function count()
    {
        $this->likes_count = $this->likes();
    }

    public function render()
    {
        return view('livewire.connect.post.post-feedback');
    }
}
