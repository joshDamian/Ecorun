<?php

namespace App\Presenters\Post;

use App\Models\Post;

class UrlPresenter
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return $this->$key;
    }

    public function show()
    {
        return route('post.show', $this->post);
    }
}
