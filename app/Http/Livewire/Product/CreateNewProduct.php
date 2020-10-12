<?php

namespace App\Http\Livewire\Product;

use App\Models\Category;
use App\Models\Enterprise;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateNewProduct extends Component
{
    use WithFileUploads;

    public Enterprise $enterprise;
    public $name;
    public $price;
    public $description;
    public $available_stock;
    public $photos = [];
    public $product;
    public $categories;
    public $activeCategory;
    public $product_category;

    protected $rules = [
        'photos.*' => [
            'required',
            'image',
            'max:4096'
        ],
        'name' => [
            'required',
            'min:4',
            'string'
        ],
        'description' => [
            'required',
            'min:20'
        ],
        'available_stock' => [
            'required',
            'int',
            'min:1'
        ],
        'price' => [
            'required',
            'int',
            'min:1'
        ],
        'product_category' => 'required'
    ];

    public function create()
    {
        $this->validate();
        $this->product = $this->enterprise
            ->products()
            ->create([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'available_stock' => $this->available_stock
            ]);

            Category::find($this->product_category)->products()->save($this->product);

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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount() 
    {
        $this->categories = Category::without('products')->where('parent_title', null)->orderBy('title', 'ASC')->get();
    }  

    public function render()
    {
        return view('livewire.product.create-new-product');
    }
}
