<x-business-layout>
    <x-buy.market-place />
    <x-product.user-product-list :products="$products" />
    <div class="mx-2 mb-2 md:mx-0">
        <x-paginator :data="$products" />
    </div>
</x-business-layout>