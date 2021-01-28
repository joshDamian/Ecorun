<?php

namespace App\Http\Livewire\Traits;

use App\Models\Post;

trait HasFeedback
{
    public $feedbackable;
    private $feedback_names = [
        Post::class => 'comments'
    ];
    public $feedbackReady = false;

    public function feedbacks()
    {
        $feedback_name = $this->feedback_names[get_class($this->feedbackable)];
        return $this->feedbackable->loadMissing($feedback_name)->{$feedback_name}->count();
    }

    public function toogleFeedback()
    {
        $this->feedbackReady = !$this->feedbackReady;
    }
}
