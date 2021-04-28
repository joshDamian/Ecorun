<?php

namespace App\Presenters\Post;

use App\DataBanks\Post\AttachmentsDataBank;
use App\Models\Connect\Content\Post;
use App\Presenters\Traits\AttachmentsBehaviours;

class AttachmentsPresenter
{
    use AttachmentsBehaviours;

    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->attachments = (new AttachmentsDataBank($this->post))->fetch();
    }
}
