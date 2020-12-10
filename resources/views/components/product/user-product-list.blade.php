@props(['products'])
<div>
    <div class="grid grid-cols-2 gap-1 sm:gap-1 sm:grid-cols-3 md:grid-cols-4">
        @foreach($products as $product)
        <div>
            <x-product.product-preview-card :product="$product" />
        </div>
        @endforeach
    </div>
</div>
