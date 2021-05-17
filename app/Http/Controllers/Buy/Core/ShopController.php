<?php

namespace App\Http\Controllers\Buy\Core;

use Illuminate\Http\Request;
use App\Models\Build\Sellable\Product\Product;
use App\Http\Controllers\Controller;
use App\Models\Build\Business\Business;
use App\Models\Build\Sellable\Sellable;
use App\Models\Buy\Service\Service;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $wares = Sellable::with(['vendor'])->latest()->paginate(12);
        $businesses = $wares->filter(function ($ware) {
            return $ware->vendor_type === Business::class;
        })->pluck('vendor')->unique('id');
        return view('shop.index', compact('wares', 'businesses'));
    }

    public function products()
    {
        $products = Sellable::with(['vendor'])->where('sellable_type', Product::class)->latest()->paginate(12);
        $businesses = $products->filter(function ($product) {
            return $product->vendor_type === Business::class;
        })->pluck('vendor')->unique('id');
        return view('shop.products', compact('products', 'businesses'));
    }

    public function services()
    {
        $services = Sellable::with(['vendor'])->where('sellable_type', Service::class)->latest()->paginate(12);
        $businesses = $services->filter(function ($service) {
            return $service->vendor_type === Business::class;
        })->pluck('vendor')->unique('id');
        return view('shop.services', compact('services', 'businesses'));
    }
}
