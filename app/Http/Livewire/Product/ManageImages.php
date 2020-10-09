<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ManageImages extends Component
{
    public Product $product;
    public $photos = [];

    protected $rules = [
        'photos.*' => [
            'required',
            'image',
            'max:4096'
        ],
    ];

    public function deletImage($image) {
        Storage::disk('public')->delete($product->gallery()->find($image)->image_url);
        $this->product->gallery()->find($image)->delete();
    }

    public function saveImages() {
        $this->validate();

        foreach ($this->photos as $photo) {
            $photo_path = $photo->store('product-photos', 'public');
            $photo = Image::make(public_path("/storage/{$photo_path}"))->fit(1024, 1024);
            $photo->save();

            $this->product->gallery()->create([
                'image_url' => $photo_path,
                'label' => 'product_image'
            ]);
        }
    }

    public function render() {
        return view('livewire.product.manage-images');
    }
}