<x-app-layout>
    <div>
        <p class="text-blue-700 font-semibold mb-2 text-lg">
            {{ __('Browsing History') }}
        </p>
        @auth
        <div class="grid grid-cols-2 sm:gap-3 gap-2 sm:grid-cols-3 md:grid-cols-4">
            @foreach($product_history_log as $log_item)
            <div>
                <x-product.product-preview-card :product="$log_item->product" />
            </div>
            @endforeach
        </div>
        <x-paginator :data="$product_history_log" />
        @endauth
        @guest
        <x-product.user-product-list :products="$product_history_log" />
        @endguest
    </div>
</x-app-layout>
