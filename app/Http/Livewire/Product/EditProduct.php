<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class EditProduct extends Component
{
    public Product $product;
    protected $rules = [
        'product.name' => [
            'required',
            'min:4',
            'string'
        ],
        'product.description' => [
            'required',
            'min:20'
        ],
        'product.available_stock' => [
            'required',
            'int',
            'min:1'
        ],
        'product.price' => [
            'required',
            'int',
            'min:1'
        ]
    ];

    public function save()
    {
        $this->validate();

        $this->product->save();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.product.edit-product');
    }
}
