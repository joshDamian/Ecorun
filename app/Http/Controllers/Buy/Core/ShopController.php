<?php

namespace App\Http\Controllers\Buy\Core;

use Illuminate\Http\Request;
use App\Models\Build\Sellable\Product\Product;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with([
            'gallery' => function ($query) {
                return $query->cacheFor(now()->addDays(30));
            }
        ])->latest()->paginate(12);
        return view('shop.index', compact('products'));
    }
}
