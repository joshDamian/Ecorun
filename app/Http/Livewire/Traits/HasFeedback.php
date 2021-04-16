<?php

namespace App\Http\Livewire\Traits;

use App\Models\Post;
use App\Models\Feedback;

trait HasFeedback
{
    public $feedbackable;
    private $feedback_names = [
        Post::class => 'comments',
        Feedback::class => 'replies'
    ];
    public $feedbackReady = false;
    public $feedbacksPerPage = 15;

    public function feedbacks()
    {
        if (is_object($this->feedbackable)) {
            $feedback_name = $this->feedback_names[$this->feedbackable::class];
            return $this->feedbackable->loadMissing($feedback_name)->{$feedback_name}->count();
        }
        return;
    }

    public function toogleFeedback()
    {
        $this->feedbackReady = !$this->feedbackReady;
    }
}
