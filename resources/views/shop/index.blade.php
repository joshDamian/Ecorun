<x-business-layout>
    <x-buy.market-place />
    <x-product.user-product-list :products="$products" />

    @if($products->count() < 1)
        <div class="p-4">
            <div class="flex items-center justify-center">
                <i style="font-size: 6rem;" class="fas fa-shopping-bag text-blue-700"></i>
            </div>
            <div class="mt-4 text-lg font-semibold text-center text-blue-700">
                no products to display.
            </div>
        </div>
        @endif

        <div class="mx-2 mb-2 md:mx-0">
            <x-paginator :data="$products" />
        </div>
    </x-business-layout>