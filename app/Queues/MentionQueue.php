<?php

namespace App\Queues;

class MentionQueue
{
    private $mentions = [];

    public function addMention($mention)
    {
        if (!in_array($mention, $this->mentions)) {
            $this->mentions[] = $mention;
        }
    }
    public function getMentions()
    {
        return $this->mentions;
    }
}
