<?php

namespace App\Engines;

use App\Crawlers\SearchEngineCrawler;
use Illuminate\Support\Facades\App;

class SearchEngine
{
    private $query;
    private array $data_sets = [
        'all', 'posts', 'products', 'profiles', 'hashtags'
    ];
    private $data_set = 'all';

    public function setQuery($query)
    {
        $this->query = trim($query);
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
        $this->data_set = (in_array($data_set, $this->data_sets)) ? $data_set : 'all';
        return $this;
    }

    public function results()
    {
        return $this->crawl()->results();
    }

    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }
        return null;
    }
}
