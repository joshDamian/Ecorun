<?php

namespace App\Crawlers;

use App\Models\Post, App\Models\Product;
use App\Models\Profile;

class SearchEngineCrawler
{
    private $results = [];

    public function crawl() {
        switch (app('search_engine')->data_set) {
            case ('all'):
                $models_with_tag = $this->crawlForTags();
                $this->results = collect(['posts' => $this->crawlForPosts()->merge($models_with_tag['posts'])->unique(), 'products' => $this->crawlForProducts()->merge($models_with_tag['products'])->unique(), 'profiles' => $this->crawlForProfiles()])->flatten();
                break;
            case ('posts'):
                $this->results = $this->crawlForPosts();
                break;
            case ('products'):
                $this->results = $this->crawlForProducts();
                break;
            case ('hashtags'):
                $this->results = $this->crawlForTags()->flatten();
                break;
            case ('profiles'):
                $this->results = $this->crawlForProfiles();
                break;
        }
        return $this;
    }

    private function crawlForPosts() {
        return Post::search(app('search_engine')->query)->get()->sortByDesc('created_at');
    }

    public function crawlForProducts() {
        return Product::search(app('search_engine')->query)->get()->sortByDesc('created_at');
    }

    public function crawlForTags() {
        return collect(['posts' => Post::withAnyTags([app('search_engine')->query])->get()->sortByDesc('created_at'), 'products' => Product::withAnyTags([app('search_engine')->query])->get()->sortByDesc('created_at')]);
    }

    public function crawlForProfiles() {
        return Profile::search(app('search_engine')->query)->get();
    }

    public function __get($key) {
        if (property_exists($this, $key)) {
            return $this-> {
                $key
        };
    }
    return null;
}

public function results() {
    return is_array($this->results) ? collect($this->results) : $this->results;
}
}