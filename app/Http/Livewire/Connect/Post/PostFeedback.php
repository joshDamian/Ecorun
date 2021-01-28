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
            "newLike.{$this->feedback_id}." . str_replace('\\', '.', get_class($this->post)) => 'likes',
            "newShare.{$this->feedback_id}." . str_replace('\\', '.', get_class($this->post)) => 'shares'
        ];
    }

    public function mount(): void
    {
        if (Auth::check()) {
            $this->profile = Auth::user()->currentProfile;
        }
        $this->feedback_id = random_int(1, 918000982092) . $this->post->id;
        $this->shareable = $this->likeable = $this->feedbackable = $this->post;
        $this->feedbackReady = ($this->view === 'post.show') ? true : null;
        return;
    }

    public function render()
    {
        return view('livewire.connect.post.post-feedback');
    }
}
