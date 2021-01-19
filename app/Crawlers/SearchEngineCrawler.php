<?php

namespace App\Crawlers;

use App\Models\Post;

class SearchEngineCrawler
{
    private $results;

    public function crawl()
    {
        switch (app('search_engine')->data_set) {
            case ('all'):
                $this->results = 'all of me';
                break;

            case ('posts'):
                $this->results = $this->crawlForPosts();
        }
        return $this;
    }

    private function crawlForPosts()
    {
        return Post::search(app('search_engine')->query)->get();
    }

    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }
        return null;
    }

    public function results()
    {
        return $this->results;
    }
}
