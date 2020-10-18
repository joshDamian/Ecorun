<?php

namespace App\Http\Livewire\UserComponents\Product;

use App\Models\Product;
use App\Models\Store;
use Livewire\Component;

class StoreProductList extends Component
{
    public function render()
    {
        $stores = Store::all();
        $stores_enterprise_id = [];

        foreach ($stores as $store) {
            array_push($stores_enterprise_id, $store->enterprise->id);
        }

        return view('livewire.user-components.product.store-product-list', [
            'store_products' => Product::whereIn('enterprise_id', $stores_enterprise_id)->where('is_published', true)->latest()->paginate(10)
        ]);
    }
}
