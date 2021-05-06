<?php

namespace App\Presenters\Product;

use App\Models\Build\Sellable\Product\Product;
use App\Presenters\Presenter;

class UrlPresenter
{
    use Presenter;

    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function show()
    {
        return route('product.show', ['product' => $this->product, 'slug' => $this->product->data_slug('name')]);
    }
}
