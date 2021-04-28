<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use App\Models\Build\Sellable\Product\Product;
use Livewire\Component;

class ManageProductSpecifications extends Component
{
    public Product $product;

    protected $listeners = [
        'modifiedSpecifications' => '$refresh',
    ];

    public function render()
    {
        $specifications = $this->product->specifications;
        return view('livewire.build-and-manage.product.manage-product-specifications', [
            'specifications' => $specifications,
            'specifications_count' => $specifications->count()
        ]);
    }
}
