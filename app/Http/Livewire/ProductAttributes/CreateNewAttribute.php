<?php

namespace App\Http\Livewire\ProductAttributes;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Validation\Rule;

class CreateNewAttribute extends Component
{
    public Product $product;

    public $name;
    public $value = [];
    public $ready;

    protected $rules = [];

    public function create()
    {
        $this->validate([
            'name' => [
                'required',
                'min:3',
                Rule::unique('product_attributes', 'name')->where(function ($query) {
                    return $query->where('product_id', $this->product->id);
                })
            ],
            'value' => 'required'
        ]);

        $this->value = explode(',', $this->value);

        foreach ($this->value as $key => $value) {
            $this->value[$key] = trim($value);
        }

        $this->product->attributes()->create([
            'name' => $this->name,
            'value' => $this->value
        ]);

        $this->nevermind();

        $this->emit('modifiedAttributes');
    }

    public function add()
    {
        $this->ready = true;
    }

    public function nevermind()
    {
        $this->ready = null;
        $this->name = null;
        $this->value = null;

        return true;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => [
                'required',
                'min:3',
                Rule::unique('product_attributes', 'name')->where(function ($query) {
                    return $query->where('product_id', $this->product->id);
                })
            ],
            'value' => 'required'
        ]);
    }

    public function render()
    {
        return view('livewire.product-attributes.create-new-attribute');
    }
}
