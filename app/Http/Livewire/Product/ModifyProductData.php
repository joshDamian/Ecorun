<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class ModifyProductData extends Component
{
    public Product $product;

    public function render()
    {
        return view('livewire.product.modify-product-data');
    }
}
