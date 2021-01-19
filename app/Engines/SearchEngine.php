<?php

namespace App\Engines;

use App\Crawlers\SearchEngineCrawler;
use Illuminate\Support\Facades\App;

class SearchEngine
{
    private array $data_sets = [
        'profiles' => Profile::class,
        'posts' => Post::class,
        'products' => Product::class,
        'categories' => Category::class
    ];
    private $query;
    private $data_set = 'all';

    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    public function crawl()
    {
        App::singleton('search_crawler', function () {
            return new SearchEngineCrawler;
        });
        return app('search_crawler')->crawl();
    }

    public function setDataSet(?string $data_set = 'all')
    {
        $this->data_set = $data_set;
        return $this;
    }

    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }
        return null;
    }
}
