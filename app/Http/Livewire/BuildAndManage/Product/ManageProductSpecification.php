<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use App\Models\Product;
use Livewire\Component;

class ManageProductSpecification extends Component
{
    public Product $product;

    protected $listeners = [
        'modifiedAttributes' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.build-and-manage.product.manage-product-specification', [
            'attributes' => $this->product->attributes()->orderBy('name', 'ASC')->get()
        ]);
    }
}
