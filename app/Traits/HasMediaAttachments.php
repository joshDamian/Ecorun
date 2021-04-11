<?php

namespace App\Traits;

use App\Models\Video;
use App\Models\Audio;
use App\Models\Music;

trait HasMediaAttachments
{
    abstract public function getAttachmentsAttribute();

    public function video_attachments()
    {
        return $this->morphMany(Video::class, 'attachable');
    }

    public function audio_attachments()
    {
        return $this->morphMany(Audio::class, 'attachable');
    }

    public function music_attachments()
    {
        return $this->morphMany(Music::class, 'attachable');
    }

    public function hasAttachedMusic()
    {
        return $this->attachments->music->isNotEmpty();
    }
}
