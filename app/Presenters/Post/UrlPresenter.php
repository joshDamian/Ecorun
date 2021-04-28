<?php

namespace App\Presenters\Post;

use App\Models\Connect\Content\Post;
use App\Presenters\Presenter;

class UrlPresenter
{
    use Presenter;

    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function show()
    {
        return route('post.show', $this->post);
    }

    public function edit()
    {
        return route('post.edit', $this->post);
    }

    public function delete()
    {
        return route('post.delete', $this->post);
    }
}
