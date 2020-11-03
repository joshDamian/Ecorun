<?php

namespace App\Http\Livewire\UserComponents\Product;

use App\Models\Product;
use Livewire\Component;

class EnterpriseProducts extends Component
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
        return view('livewire.user-components.product.enterprise-products');
    }
}
