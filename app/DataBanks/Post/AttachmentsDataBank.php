<?php

namespace App\DataBanks\Post;

use App\DataBanks\DataBank;
use App\Models\Connect\Content\Post;

class AttachmentsDataBank implements DataBank
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post->loadMissing('gallery', 'video_attachments', 'audio_attachments', 'music_attachments');
    }

    public function fetch()
    {
        return collect([
            'photos' => $this->post->gallery,
            'videos' => $this->post->video_attachments,
            'audio' => $this->post->audio_attachments,
            'music' => $this->post->music_attachments
        ]);
    }
}
