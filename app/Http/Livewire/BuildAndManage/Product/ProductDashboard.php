<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use App\Models\Product;
use Livewire\Component;

class ProductDashboard extends Component
{
    public Product $product;

    public function render()
    {
        return view('livewire.build-and-manage.product.product-dashboard');
    }
}
