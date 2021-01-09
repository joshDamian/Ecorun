<?php

namespace App\Queues;

class TagQueue
{
    private $tags = [];

    public function addTag($tag)
    {
        $this->tags[] = $tag;
    }
    public function getTags()
    {
        return $this->tags;
    }
}
