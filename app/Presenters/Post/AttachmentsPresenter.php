<?php

namespace App\Presenters\Post;

use App\DataBanks\Post\AttachmentsDataBank;
use App\Models\Post;

class AttachmentsPresenter
{
    private Post $post;
    private $attachments;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->attachments = (new AttachmentsDataBank($this->post))->fetch();
    }
}
