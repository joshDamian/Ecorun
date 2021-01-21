<?php

namespace App\Http\Livewire\Buy\LandingPage;

use App\Models\Product;
use App\Models\Store;
use Livewire\Component;

class FeaturedStoreProducts extends Component
{
    public function render()
    {
        $stores = Store::all()->pluck('business.id');

        return view('livewire.buy.landing-page.featured-store-products', [
            'store_products' => Product::whereIn('business_id', $stores)->latest()->paginate(8)
        ]);
    }
}
