<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use App\Models\Build\Sellable\Product\Product;
use Livewire\Component;

class ProductDashboard extends Component
{
    public Product $product;
    protected $listeners = [
        'unpublishedMe' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.build-and-manage.product.product-dashboard');
    }
}
