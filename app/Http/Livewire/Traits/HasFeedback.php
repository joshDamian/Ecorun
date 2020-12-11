<?php

namespace App\Http\Livewire\Traits;

trait HasFeedback
{
    public $feedbackReady = false;

    public function toogleFeedback()
    {
        $this->feedbackReady = !$this->feedbackReady;
    }
}
