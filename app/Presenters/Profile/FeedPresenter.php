<?php

namespace App\Presenters\Profile;

use App\DataBanks\Profile\FeedDataBank;
use App\Models\Post;
use App\Models\Product;
use App\Models\Profile;

class FeedPresenter
{
    protected Profile $profile;
    protected $feed;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
        $this->feed = (new FeedDataBank($this->profile))->fetch();
    }

    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return $this->$key;
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
            dump($post->mentions);
            return $post->mentions->contains($this->profile->id);
        });
    }
}
