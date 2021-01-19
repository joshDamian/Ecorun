<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use App\Http\Livewire\Traits\UploadPhotos;
use App\Models\Category;
use App\Models\Product;
use Faker\Generator;
use Livewire\Component;

class CreateNewProduct extends Component
{
    use UploadPhotos;

    public $business;
    public $photos = [];
    public $product_created = false;
    public $product = ['_name', '_description', '_price', '_available stock'];
    public $business_is_store;

    public function create()
    {
        $this->validate();

        $this->product = $this->business
            ->products()->create(
                [
                    'name' => ucwords(strtolower($this->product['_name'])),
                    'description' => $this->product['_description'],
                    'price' => $this->product['_price'],
                    'available_stock' => $this->product['_available stock'],
                ]
            );

        /*  Category::find($this->product_category->title)->products()->save($this->product);
        */
        $this->uploadPhotos('product-photos', $this->product, 'product_image', array(1600, 1600));
        $this->product_created = true;
    }

    public function getRules(): array
    {
        return [
            'photos.*' => ['image', 'max:7168'],
            'photos' => 'required',
            'product._name' => ['required', 'min:4', 'string'],
            'product._description' => ['required', 'min:20'],
            'product._available stock' => ($this->business_is_store || (!empty($this->product['_available stock'])))
                ? ['required', 'int', 'min:1'] : '',
            'product._price' => ['required', 'int', 'min:1'],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetData()
    {
        return $this->reset('product_created', 'product', 'photos');
    }

    public function mount()
    {
        $this->business_is_store = $this->business->isStore();
    }

    public function render()
    {
        return view('livewire.build-and-manage.product.create-new-product');
    }
}
