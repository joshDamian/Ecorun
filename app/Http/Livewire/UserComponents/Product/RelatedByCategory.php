<?php

namespace App\Http\Livewire\UserComponents\Product;

use App\Models\Product;
use Livewire\Component;

class RelatedByCategory extends Component
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
        return view('livewire.user-components.product.related-by-category');
    }
}
