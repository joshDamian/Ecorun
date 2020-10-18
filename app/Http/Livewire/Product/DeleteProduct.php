<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DeleteProduct extends Component
{
    public Product $product;
    public $confirm;

    public function delete()
    {
        $enterprise_id = $this->product->enterprise_id;
        $this->product->attributes()->delete();

        foreach ($this->product->gallery as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        $this->product->gallery()->delete();

        $this->product->forceDelete();

        redirect()->to("/e-prises/{$enterprise_id}/products");
    }

    public function confirmDeleteProduct()
    {
        $this->confirm = true;
    }

    public function render()
    {
        return view('livewire.product.delete-product');
    }
}
