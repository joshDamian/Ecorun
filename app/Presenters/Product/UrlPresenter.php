<?php

namespace App\Presenters\Product;

use App\Models\Product;

class UrlPresenter
{
    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return $this->$key;
    }

    public function show()
    {
        return route('product.show', ['product' => $this->product, 'slug' => $this->product->data_slug('name')]);
    }
}
