<?php

namespace App\Http\Livewire\Connect\Post\Comment;

use App\Http\Livewire\Traits\HasFeedback;
use App\Http\Livewire\Traits\HasLikes;
use Livewire\Component;
use App\Models\Connect\ContentFeedback\Feedback;
use Illuminate\Support\Facades\Auth;

class CommentFeedback extends Component
{
    use HasLikes;
    use HasFeedback;

    public Feedback $comment;
    public string $view;

    public function getListeners()
    {
        return [
            'newFeedback' => '$refresh',
            "newLike.{$this->feedback_id}." . str_replace('\\', '.', get_class($this->comment)) => 'likes',
        ];
    }

    public function mount(): void
    {
        if (Auth::check()) {
            $this->profile = Auth::user()->currentProfile;
        }
        $this->feedback_id = random_int(1, 918000982092) . $this->comment->id;
        $this->likeable = $this->feedbackable = $this->comment;
        $this->feedbackReady = ($this->view === 'comment.show' && $this->comment->parentIsPost()) ? true : null;
        return;
    }

    public function render()
    {
        return view('livewire.connect.post.comment.comment-feedback');
    }
}
