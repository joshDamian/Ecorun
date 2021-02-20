<?php

namespace App\Http\Livewire\Buy\Cart;

use Livewire\Component;

class ManageAuthCart extends Component
{
    public $confirm;

    public function getCartItemsProperty()
    {
        return auth()->user()->cart()->with('product.gallery', 'product.specifications')->paginate(15);
    }

    public function render()
    {
        return view('livewire.buy.cart.manage-auth-cart', [
            'cartItems' => $this->cartItems
        ]);
    }
}
