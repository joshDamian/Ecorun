<?php

namespace App\Http\Livewire\Connect\Post;

use App\Http\Livewire\Traits\HasFeedback;
use App\Http\Livewire\Traits\HasLikes;
use App\Http\Livewire\Traits\HasShares;
use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostFeedback extends Component
{
    use HasLikes;
    use HasShares;
    use HasFeedback;

    public Post $post;
    public string $view;

    public function getListeners()
    {
        return [
            'newFeedback' => '$refresh',
            "newLike.{$this->post->id}" => 'likes',
            "newShare.{$this->post->id}" => 'shares'
        ];
    }

    public function mount(): void
    {
        $this->profile = Auth::user()->loadMissing('currentProfile')->currentProfile;
        $this->shareable = $this->likeable = $this->post;
        $this->feedbackReady = ($this->view === 'post.show') ? true : null;
        return;
    }

    public function render()
    {
        return view('livewire.connect.post.post-feedback');
    }
}
