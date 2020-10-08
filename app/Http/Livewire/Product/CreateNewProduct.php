<?php

namespace App\Http\Livewire\Product;

use App\Models\Enterprise;
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

    protected $rules = [
        'photos.*' => ['required', 'image', 'max:3072'],
        'name' => ['required', 'min:4', 'string'],
        'description' => ['required', 'min:20'],
        'available_stock' => ['required', 'int', 'min:1'],
        'price' => ['required', 'int', 'min:1']
    ];

    public function create()
    {
        $this->validate();

        $this->enterprise()
            ->products()
            ->create([
                'name' => $this->name
            ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.product.create-new-product');
    }
}
