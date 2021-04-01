<?php

namespace App\Presenters\Traits;

use App\Presenters\Presenter;

trait AttachmentsBehaviours
{
    use Presenter;

    private $attachments;

    public function all()
    {
        return $this->attachments?->flatten();
    }

    public function music()
    {
        return $this->attachments['music'];
    }

    public function audio()
    {
        return $this->attachments['audio'];
    }
}
