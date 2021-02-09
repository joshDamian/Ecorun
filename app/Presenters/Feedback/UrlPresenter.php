<?php

namespace App\Presenters\Feedback;

use App\Models\Feedback;

class UrlPresenter
{
    protected Feedback $feedback;

    public function __construct(Feedback $feedback) {
        $this->feedback = $feedback;
    }

    public function __get($key) {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return $this->$key;
    }

    private function show() {
        return $this->generate_url_prefix();
    }

    private function edit() {
        return $this->generate_url_prefix() . '/edit';
    }

    private function generate_url_prefix() {
        switch ($this->feedback->feedbackable_type) {
            case('App\Models\Post'):
                return '/post/' . $this->feedback->feedbackable_id . '/comment/' . $this->feedback->id;
                break;
            default:
                break;
        }
    }

    private function delete() {
        return $this->generate_url_prefix() . '/delete';
    }
}