<?php

namespace App\Http\Livewire\UserComponents\Cart;

use Livewire\Component;

class CartTrigger extends Component
{
    public $view;

    public function render()
    {
        return view('livewire.user-components.cart.cart-trigger');
    }
}
