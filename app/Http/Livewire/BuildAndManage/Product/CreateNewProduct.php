<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use App\Models\Category;
use App\Models\Business;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateNewProduct extends Component
{
    use WithFileUploads;

    public $businessId;
    public $name;
    public $price;
    public $description;
    public $available_stock;
    public $photos = [];
    public $product;
    public $categories;
    public $activeCategory;
    public $product_category;

    public function create()
    {
        $this->validate($this->rules());

        $this->product = $this->business
            ->products()
            ->create([
                'name' => ucwords(strtolower($this->name)),
                'description' => $this->description,
                'price' => $this->price,
                'available_stock' => $this->available_stock,
                'is_published' => true
            ]);

        Category::find($this->product_category)->products()->save($this->product);

        foreach ($this->photos as $photo) {
            $photo_path = $photo->store('product-photos', 'public');
            $photo = Image::make(public_path("/storage/{$photo_path}"))->fit(1600, 1600, function ($constraint) {
                $constraint->upsize();
            });
            $photo->save();

            $this->product->gallery()->create([
                'image_url' => $photo_path,
                'label' => 'product_image'
            ]);
        }
    }

    public function rules(): array
    {
        return [
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

            'available_stock' => ($this->business->isStore() || $this->available_stock || $this->available_stock === "0") ? [
                'required',
                'int',
                'min:1'
            ] : '',

            'price' => [
                'required',
                'int',
                'min:1'
            ],

            'product_category' => ($this->business->isStore()) ? ['required'] : '',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    public function mount()
    {
        $this->categories = Category::without('products')->where('parent_title', null)->orderBy('title', 'ASC')->get();
        //dump($this->categories->first());
        if ($this->categories->count() > 0) {
            $this->activeCategory = $this->categories->first()->title;
            $this->product_category = Category::find($this->activeCategory)->children()->first()->title;
        } else {
            $this->activeCategory = 'no categories yet';
            $this->product_category = 'no categories yet';
        }
    }

    public function getBusinessProperty()
    {
        return Business::find($this->businessId);
    }

    public function render()
    {
        return view('livewire.build-and-manage.product.create-new-product');
    }
}
