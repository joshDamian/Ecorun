<?php

namespace App\Http\Livewire\Buy\ProductPageSuggestion;

use App\Models\Product;
use Livewire\Component;

class CategoryRelatedProducts extends Component
{
    public $products;
    public $product;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->products = $this->product->category->products()->whereNotIn('id', [$this->product->id])
            ->where('is_published', true)
            ->latest()->get()->take(6);
    }

    public function count()
    {
        return
            $this->product->category->products()->whereNotIn('id', [$this->product->id])
            ->where('is_published', true)
            ->latest()->get()->count();
    }

    public function render()
    {
        return view('livewire.buy.product-page-suggestion.category-related-products');
    }
}
