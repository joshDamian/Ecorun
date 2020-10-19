<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class SearchProducts extends Component
{
    public $query;
    public $results = [];

    protected $listeners = [
        'search'
    ];

    public function search($query) {
        $this->results = [];
        $this->query = $query;
        $this->results = Product::search($this->query)->where('is_published', true)->take(7)->get();
    }

    public function render() {
        return view('livewire.product.search-products');
    }
}