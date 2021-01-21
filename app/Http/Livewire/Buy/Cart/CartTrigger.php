<?php

namespace App\Http\Livewire\Buy\Cart;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CartTrigger extends Component
{
    public Product $product;
    protected $listeners = [
        'modifiedCart' => '$refresh'
    ];

    public function existing()
    {
        if (Auth::check()) {
            $existing = Auth::user()->loadMissing('cart')->cart->where('product_id', $this->product->id)->isNotEmpty();
        } else {
            (session()->get('guest_cart')) ? true : session()->put('guest_cart', []);
            $guest_cart = session()->get('guest_cart');
            $existing = array_key_exists($this->product->id, $guest_cart);
        }
        return $existing;
    }

    public function render()
    {
        return view('livewire.buy.cart.cart-trigger');
    }
}
