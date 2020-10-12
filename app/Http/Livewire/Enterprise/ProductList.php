<?php

namespace App\Http\Livewire\Enterprise;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductList extends Component
{
    public $enterprise;

    public $active_product;

    public function switchActiveProduct(Product $product)
    {
        $this->active_product = $product;
    }

    public function viewAll()
    {
        $this->active_product = null;
    }

    public function render()
    {
        return view('livewire.enterprise.product-list', [
            'products' => Auth::user()->isManager->enterprises->find($this->enterprise)->products
        ]);
    }
}
