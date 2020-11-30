<?php

namespace App\Http\Livewire\Buy\ProductPageSuggestion;

use App\Models\Product;
use Livewire\Component;

class BusinessRelatedProducts extends Component
{
    public $products;
    public $product;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->products = $this->product->enterprise->products()->whereNotIn('id', [$this->product->id])
            ->latest()->get()->take(6);
    }

    public function count()
    {
        return $this->product->enterprise->products()->whereNotIn('id', [$this->product->id])
            ->latest()->get()->count();
    }

    public function render()
    {
        return view('livewire.buy.product-page-suggestion.business-related-products');
    }
}
