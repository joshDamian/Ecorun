<?php

namespace App\Presenters\Post;

use App\DataBanks\Post\FollowersDataBank;
use App\Models\Post;

class FollowersPresenter
{
    private Post $post;
    private $followers;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->followers = (new FollowersDataBank($this->post))->fetch();
    }

    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return $this->$key;
    }
}
