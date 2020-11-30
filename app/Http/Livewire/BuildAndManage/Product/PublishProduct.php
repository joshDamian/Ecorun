<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use App\Models\Product;
use Livewire\Component;

class PublishProduct extends Component
{
    public Product $product;

    public function publish()
    {
        $this->product->is_published = true;
        $this->product->save();
        $this->emit('publishingEffect');
    }

    public function unpublish()
    {
        $this->product->is_published = false;
        $this->product->save();
        $this->emit('publishingEffect');
    }

    public function render()
    {
        return view('livewire.build-and-manage.product.publish-product');
    }
}
