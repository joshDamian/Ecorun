<?php

namespace App\Http\Livewire\UserComponents\Product;

use App\Models\Product;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentlyViewed extends Component
{
    public $product;
    public $products;
    private $session;

    public function mount(Product $product, SessionManager $session)
    {
        $this->product = $product;
        $this->session = $session;

        if (Auth::user()) {
            $view_history = Auth::user()->view_history()->whereNotIn('product_id', [$this->product->id])->orderBy('updated_at', 'DESC')->get()->pluck('product_id');
            $this->products = Product::whereIn('id', $view_history)->where('is_published', true)->get()->take(6);
        } else {
            $this->products = Product::whereIn('id', $this->session->get('product_view_history'))->where('id', '!=', $this->product->id)->where('is_published', true)->get()->take(6);
        }
    }

    public function count()
    {
        if (Auth::user()) {
            $view_history = Auth::user()->view_history()->whereNotIn('product_id', [$this->product->id])->get()->pluck('product_id');
            $count = Product::whereIn('id', $view_history)->get()->count();
        } else {
            $count = Product::whereIn('id', $this->session->get('product_view_history'))->where('id', '!=', $this->product->id)->get()->count();
        }

        return $count;
    }

    public function render()
    {
        return view('livewire.user-components.product.recently-viewed');
    }
}
