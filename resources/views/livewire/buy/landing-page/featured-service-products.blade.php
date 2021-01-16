<div>
    @if($service_products->count() > 0)
    <x-product.user-product-list :products="$service_products" />
    @endif
</div>
