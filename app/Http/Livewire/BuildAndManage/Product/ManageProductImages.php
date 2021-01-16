<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\WithFileUploads;

class ManageProductImages extends Component
{
    use WithFileUploads;
    public Product $product;
    public $photos = [];

    protected $rules = [
        'photos.*' => [
            'required',
            'image',
            'max:4096'
        ],
    ];

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public function deleteImage($image)
    {
        Storage::disk('public')->delete($this->product->gallery()->find($image)->image_url);
        $this->product->gallery()->find($image)->delete();
        $this->emitSelf('refresh');
    }

    public function saveImages()
    {
        $this->validate();

        foreach ($this->photos as $photo) {
            $photo_path = $photo->store('product-photos', 'public');
            $photo = Image::make(public_path("/storage/{$photo_path}"))->fit(1600, 1600);
            $photo->save();

            $this->product->gallery()->create([
                'image_url' => $photo_path,
                'label' => 'product_image'
            ]);
        }

        $this->emitSelf('refresh');
    }

    public function render()
    {
        return view('livewire.build-and-manage.product.manage-product-images');
    }
}
