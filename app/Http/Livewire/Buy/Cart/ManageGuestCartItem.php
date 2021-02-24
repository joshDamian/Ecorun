<?php

namespace App\Http\Livewire\Buy\Cart;

use Livewire\Component;

class ManageGuestCartItem extends Component
{
    public $cartItem;
    public $confirm;
    public $max_quantity;
    public $specifications = [];
    public $selectableSpecs;

    public function mount()
    {
        $this->max_quantity = $this->cartItem->product->available_stock;
        $this->selectableSpecs = $this->cartItem->product->specifications->filter(function ($spec) {
            return $spec->is_specific === true;
        });
        $this->specifications = $this->cartItem->specifications;
    }

    public function getRules()
    {
        return [
            'cartItem.quantity' => [
                'required', 'int', 'min:1', "max:{$this->max_quantity}"
            ],
            'specifications.*' => ['required'],
            'cartItem.product_id' => ['required'],
            'cartItem.created_at' => ['required']
        ];
    }

    public function edit()
    {
        $this->validate();
        $this->cartItem->specifications = $this->specifications;
        $this->cartItem->updated_at = now();
        session()->put("guest_cart.{$this->cartItem->product_id}", $this->cartItem);
        $this->emitSelf('saved');
        $this->emit('refreshCartDisplay');
    }

    public function cancel()
    {
        $this->emit('cancelEdit');
        return $this->reset('confirm');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function messages()
    {
        return [
            'specifications.*.required' => 'This value is required'
        ];
    }

    public function render()
    {
        return view('livewire.buy.cart.manage-guest-cart-item');
    }
}
