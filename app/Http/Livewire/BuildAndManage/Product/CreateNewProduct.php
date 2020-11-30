<?php

namespace App\Http\Livewire\BuildAndManage\Product;

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

    protected $rules = [];

    public function create()
    {
        $this->validate([
            'photos.*' => [
                'image',
                'max:7168'
            ],

            'photos' => 'required',

            'name' => [
                'required',
                'min:4',
                'string'
            ],

            'description' => [
                'required',
                'min:20'
            ],

            'available_stock' => ($this->enterprise->isStore() || $this->available_stock || $this->available_stock === "0") ? [
                'required',
                'int',
                'min:1'
            ] : '',

            'price' => [
                'required',
                'int',
                'min:1'
            ],
            
            'product_category' => ($this->enterprise->isStore()) ? ['required'] : '',
        ]);

        $this->product = $this->enterprise
            ->products()
            ->create([
                'name' => ucwords(strtolower($this->name)),
                'description' => $this->description,
                'price' => $this->price,
                'available_stock' => $this->available_stock
            ]);

        Category::find($this->product_category)->products()->save($this->product);

        foreach ($this->photos as $photo) {
            $photo_path = $photo->store('product-photos', 'public');
            $photo = Image::make(public_path("/storage/{$photo_path}"))->fit(1600, 1600);
            $photo->save();

            $this->product->gallery()->create([
                'image_url' => $photo_path,
                'label' => 'product_image'
            ]);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'photos.*' => [
                'required',
                'image',
                'max:7168'
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

            'available_stock' => ($this->enterprise->isStore() || $this->available_stock || $this->available_stock === "0") ? [
                'required',
                'int',
                'min:1'
            ] : '',

            'price' => [
                'required',
                'int',
                'min:1'
            ],
            'product_category' => ($this->enterprise->isStore()) ? ['required'] : '',
        ]);
    }

    public function mount()
    {
        $this->categories = Category::without('products')->where('parent_title', null)->orderBy('title', 'ASC')->get();
        $this->activeCategory = $this->categories->first()->title;
        $this->product_category = Category::find($this->activeCategory)->children->first()->title;
    }

    public function render()
    {
        return view('livewire.build-and-manage.product.create-new-product');
    }
}
