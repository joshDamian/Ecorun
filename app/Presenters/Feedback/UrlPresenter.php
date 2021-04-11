<?php

namespace App\Presenters\Feedback;

use App\Models\Feedback;
use App\Presenters\Presenter;

class UrlPresenter
{
    use Presenter;
    protected Feedback $feedback;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    private function show()
    {
        return $this->generate_url_prefix();
    }

    private function edit()
    {
        return $this->generate_url_prefix() . '/edit';
    }

    private function generate_url_prefix()
    {
        switch ($this->feedback->feedbackable_type) {
            case ('App\Models\Post'):
                return '/post/' . $this->feedback->feedbackable_id . '/comment/' . $this->feedback->id;
                break;
            case ('App\Models\Feedback'):
                if ($this->feedback->parentIsFeedback())
                    return '/post/' . $this->feedback->feedbackable->feedbackable_id . '/comment/' . $this->feedback->feedbackable_id . '/replies/' . $this->feedback->id;
                break;
            default:
                break;
        }
    }

    private function delete()
    {
        return $this->generate_url_prefix() . '/delete';
    }
}
