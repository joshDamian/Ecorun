<?php

namespace App\Presenters\Profile;

use App\DataBanks\Profile\FeedDataBank;
use App\Models\Connect\Content\Post;
use App\Models\Build\Sellable\Product\Product;
use App\Models\Connect\Profile\Profile;
use App\Models\Connect\Content\Share;
use App\Presenters\Presenter;

class FeedPresenter
{
    use Presenter;

    protected Profile $profile;
    protected $feed;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
        $this->feed = (new FeedDataBank($this->profile))->fetch();
    }

    public function all()
    {
        return $this->feed->flatten();
    }

    public function products()
    {
        return $this->feed[Product::class];
    }

    public function posts()
    {
        return $this->feed[Post::class];
    }

    public function photos()
    {
        return $this->feed[Post::class]->filter(function ($post) {
            return $post->gallery->count() > 0;
        });
    }

    public function mentions()
    {
        return $this->feed[Post::class]->filter(function ($post) {
            return $post->mentions->contains($this->profile->id);
        });
    }

    public function profile_suggestions()
    {
        return $this->feed[Profile::class];
    }

    public function shares()
    {
        return $this->feed[Share::class];
    }
}
