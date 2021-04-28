<?php

namespace App\Http\Livewire\General\Search;

use App\Engines\SearchEngine;
use Illuminate\Support\Facades\App;
use App\Models\Connect\Content\Post;
use App\Models\Build\Sellable\Product\Product;
use App\Models\Connect\Profile\Profile;
use Livewire\Component;

class SearchComponent extends Component
{
    public $query = '';
    public $data_set = 'all';
    public $view_for_search_models = [
        Post::class => 'includes.feed-display-cards.post-display',
        Product::class => 'includes.feed-display-cards.product-display',
        Profile::class => 'includes.profile-display-cards.search-result-display-card'
    ];
    public $display = false;

    public function initialize()
    {
        return $this->display = true;
    }

    public function getResultsProperty()
    {
        App::singleton('search_engine', function () {
            return new SearchEngine;
        });
        return ($this->display) ? app('search_engine')->setQuery($this->query)->setDataSet($this->data_set)->results() : collect([]);
    }

    public function render()
    {
        return view('livewire.general.search.search-component');
    }
}
