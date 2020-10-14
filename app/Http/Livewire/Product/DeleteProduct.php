<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;

class DeleteProduct extends Component
{
    public $confirm;

    public function confirmDeleteProduct()
    {
        $this->confirm = true;
    }

    public function render()
    {
        return view('livewire.product.delete-product');
    }
}
