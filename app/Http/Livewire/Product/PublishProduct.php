<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class PublishProduct extends Component
{
    public Product $product;

    public function publish()
    {
        $this->product->is_published = true;
        $this->product->save();
    }

    public function unpublish()
    {
        $this->product->is_published = false;
        $this->product->save();
    }

    public function render()
    {
        return view('livewire.product.publish-product');
    }
}
