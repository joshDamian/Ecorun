<?php

namespace App\Http\Livewire\Buy\Cart;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartItemsCounter extends Component
{
    public $count;

    protected $listeners = [
        'modifiedCart' => 'count'
    ];

    public function count()
    {
        $this->count = (Auth::user()) ? Auth::user()->cart->count() : count(session()->get('guest_cart', []));
    }

    public function mount()
    {
        $this->count = (Auth::user()) ? Auth::user()->cart->count() : count(session()->get('guest_cart', []));
    }

    public function render()
    {
        return view('livewire.buy.cart.cart-items-counter');
    }
}
