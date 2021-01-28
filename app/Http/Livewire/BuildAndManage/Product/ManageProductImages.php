<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Http\Livewire\Traits\UploadPhotos;

class ManageProductImages extends Component
{
    use UploadPhotos;
    public Product $product;
    public $photos = [];

    protected $rules = [
        'photos.*' => [
            'required',
            'image',
            'max:5120'
        ],
    ];

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public function deleteImage($image)
    {
        $image = $this->product->gallery->find($image);
        Storage::disk('public')->delete($image->image_url);
        $image->delete();
        if ($this->product->gallery->count() === 0) {
            $this->product->forceFill([
                'is_published' => false
            ])->save();
            $this->emitTo('build-and-manage.product.product-dashboard', 'unpublishedMe');
        }
        return $this->emitSelf('refresh');
    }

    public function saveImages()
    {
        $this->validate();
        $this->uploadPhotos('product-photos', $this->product, 'product_image', array(1600, 1600));
        $this->emitSelf('refresh');
    }

    public function render()
    {
        return view('livewire.build-and-manage.product.manage-product-images');
    }
}
