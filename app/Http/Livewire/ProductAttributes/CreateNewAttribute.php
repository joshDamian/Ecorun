<?php

namespace App\Http\Livewire\ProductAttributes;

use Livewire\Component;
use App\Models\Product;

class CreateNewAttribute extends Component
{
    public Product $product;

    public $name;
    public $value;
    public $ready;

    protected $rules = [
        'name' => [
            'required',
            'min:3'
        ],
        'value' => 'required'
    ];

    public function create() {
        $this->validate();
        if (is_array(explode(",", $this->value))) {
            $this->value = explode(",", $this->value);
        }
        $product->attributes()->create([
            'name' => $this->name,
            'value' => $this->value
        ]);
        $this->ready = null;
    }

    public function add() {
        $this->ready = true;
    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function render() {
        return view('livewire.product-attributes.create-new-attribute');
    }
}