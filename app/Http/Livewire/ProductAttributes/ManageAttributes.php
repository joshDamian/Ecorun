<?php

namespace App\Http\Livewire\ProductAttributes;

use App\Models\Product;
use Livewire\Component;

class ManageAttributes extends Component
{
    public Product $product;

    protected $listeners = [
        'modifiedAttributes' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.product-attributes.manage-attributes', [
            'attributes' => $this->product->attributes()->orderBy('name', 'ASC')->get()
        ]);
    }
}
