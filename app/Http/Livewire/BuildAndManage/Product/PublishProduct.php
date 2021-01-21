<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use App\Models\Product;
use Livewire\Component;

class PublishProduct extends Component
{
    public Product $product;

    public function publish()
    {
        if ($this->product->gallery->count() < 1) {
            $this->emitSelf('publishingError');
            return $this->addError('publishing', 'you cannot publish a product with no images');
        }
        $this->product->is_published = true;
        return $this->product->save();
    }

    public function unpublish()
    {
        $this->product->is_published = false;
        $this->product->save();
    }

    public function render()
    {
        return view('livewire.build-and-manage.product.publish-product');
    }
}
