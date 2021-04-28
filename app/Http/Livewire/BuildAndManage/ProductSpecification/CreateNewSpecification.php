<?php

namespace App\Http\Livewire\BuildAndManage\ProductSpecification;

use Livewire\Component;
use App\Models\Build\Sellable\Product\Product;
use Illuminate\Validation\Rule;

class CreateNewSpecification extends Component
{
    public Product $product;

    public $name;
    public $value = [];
    public $ready;
    public $is_specific = true;

    protected $rules = [];

    public function create(): \Livewire\Event
    {
        $this->validate([
            'name' => [
                'required',
                'min:3',
                Rule::unique('product_specifications', 'name')->where(function ($query) {
                    return $query->where('product_id', $this->product->id);
                })
            ],
            'value' => 'required'
        ]);

        $this->value = explode(',', $this->value);

        $this->product->specifications()->create([
            'name' => $this->name,
            'value' => collect($this->value)->filter(function ($item) {
                return !empty(trim($item));
            })->unique()->toArray(),
            'is_specific' => ($this->is_specific) ? $this->is_specific : false,
        ]);

        $this->nevermind();

        return $this->emit('modifiedSpecifications');
    }

    public function add(): void
    {
        $this->ready = true;
    }

    public function nevermind(): void
    {
        $this->ready = null;
        $this->name = null;
        $this->value = null;

        return;
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName, [
            'name' => [
                'required',
                'min:3',
                Rule::unique('product_specifications', 'name')->where(function ($query) {
                    return $query->where('product_id', $this->product->id);
                })
            ],
            'value' => 'required'
        ]);
    }

    public function render()
    {
        return view('livewire.build-and-manage.product-specification.create-new-specification');
    }
}
