<?php

namespace App\Http\Livewire\Buy\Cart;

use App\Models\Build\Sellable\Product\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CartTrigger extends Component
{
    public Product $product;
    public $view = 'product_page';
    protected $listeners = [
        'modifiedCart' => '$refresh'
    ];

    public function existing()
    {
        if (Auth::check()) {
            $existing = Auth::user()->loadMissing('cart')->cart->where('product_id', $this->product->id)->isNotEmpty();
        } else {
            (session()->get('guest_cart_store')) ? true : session()->put('guest_cart_store', []);
            $guest_cart = session()->get('guest_cart_store');
            $existing = array_key_exists($this->product->id, $guest_cart);
        }
        return $existing;
    }

    public function render()
    {
        return view('livewire.buy.cart.cart-trigger');
    }
}
