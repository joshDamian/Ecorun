<?php

namespace App\Http\Livewire\Buy\Cart;

use App\Models\Cart;
use Livewire\Component;

class ManageAuthCartItem extends Component
{
    public Cart $cartItem;
    public $confirm;
    public $specifications = [];
    public $selectableSpecs;

    public function getRules()
    {
        return [
            'cartItem.quantity' => [
                'required', 'int', 'min:1', "max:{$this->cartItem->product->available_stock}"
            ],
            'specifications.*' => ['required']
        ];
    }

    public function mount()
    {
        $this->selectableSpecs = $this->cartItem->product->specifications->filter(function ($spec) {
            return $spec->is_specific === true;
        });
        $this->specifications = $this->cartItem->specifications;
    }

    public function cancel()
    {
        $this->emit('cancelEdit');
        return $this->reset('confirm');
    }

    public function edit()
    {
        $this->validate();
        $this->cartItem->specifications = $this->specifications;
        $this->cartItem->save();
        $this->emitSelf('saved');
        $this->emit('refreshCartDisplay');
    }

    public function messages()
    {
        return [
            'specifications.*.required' => 'This value is required'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.buy.cart.manage-auth-cart-item');
    }
}
