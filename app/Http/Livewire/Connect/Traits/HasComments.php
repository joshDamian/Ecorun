<?php

namespace App\Http\Livewire\Connect\Traits;

trait HasComments
{
    public $commentsReady = false;

    public function displayComments()
    {
        $this->commentsReady = !$this->commentsReady;
    }
}
