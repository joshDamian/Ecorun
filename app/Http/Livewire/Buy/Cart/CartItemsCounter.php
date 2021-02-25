<?php

namespace App\Http\Livewire\Buy\Cart;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartItemsCounter extends Component
{
    public $count;
    private $user;

    protected $listeners = [
        'modifiedCart' => 'count'
    ];

    public function count()
    {
        $this->count = ($this->user) ? $this->user->cart->count() : count(session()->get('guest_cart_store', []));
    }

    public function mount()
    {
        $this->user = Auth::user();
        return $this->count();
    }

    public function render()
    {
        return view('livewire.buy.cart.cart-items-counter');
    }
}
