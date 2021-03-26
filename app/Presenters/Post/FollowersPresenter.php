<?php

namespace App\Presenters\Post;

use App\DataBanks\Post\FollowersDataBank;
use App\Models\Post;
use App\Presenters\Presenter;

class FollowersPresenter
{
    use Presenter;

    private Post $post;
    private $followers;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->followers = (new FollowersDataBank($this->post))->fetch();
    }
}
